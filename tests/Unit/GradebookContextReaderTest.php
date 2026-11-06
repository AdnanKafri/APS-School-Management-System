<?php

namespace Tests\Unit;

use App\Services\Gradebook\GradebookContext;
use App\Services\Gradebook\GradebookContextReader;
use App\Services\GradebookConfigService;
use App\Services\GradebookStatusService;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\TestCase;

class GradebookContextReaderTest extends TestCase
{
    private $db;
    private $files;
    private $contents = [];
    private $reads = [];
    private $unreadable = [];

    protected function setUp(): void
    {
        $app = new Application(dirname(__DIR__, 2));
        $capsule = new Manager($app);
        $capsule->addConnection(['driver'=>'sqlite', 'database'=>':memory:', 'prefix'=>'']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $this->db = $capsule->getConnection();
        $this->assertSame(':memory:', $this->db->getDatabaseName());
        $this->assertSame('sqlite', $this->db->getDriverName());
        $schema = $this->db->getSchemaBuilder();
        foreach (['years'=>['name','current_year'], 'classes'=>['name'], 'lessons'=>['class_id','name'],
            'rooms'=>['class_id','year_id'], 'term_years'=>['year_id','type']] as $table=>$columns) {
            $schema->create($table, function (Blueprint $t) use ($columns) {
                $t->increments('id');
                foreach ($columns as $column) $t->text($column)->nullable();
            });
        }
        $this->db->table('years')->insert([
            ['id'=>6,'name'=>'2026/2027','current_year'=>1],
            ['id'=>9,'name'=>'2025/2026','current_year'=>0],
            ['id'=>2,'name'=>'2027/2028','current_year'=>0],
        ]);
        $this->db->table('classes')->insert(['id'=>2,'name'=>'Grade 2']);
        $this->db->table('lessons')->insert(['id'=>409,'class_id'=>2,'name'=>'Subject']);
        $this->db->table('rooms')->insert([
            ['id'=>132,'class_id'=>2,'year_id'=>6], ['id'=>133,'class_id'=>2,'year_id'=>6],
            ['id'=>93,'class_id'=>2,'year_id'=>9], ['id'=>200,'class_id'=>2,'year_id'=>2],
        ]);
        $this->db->table('term_years')->insert([
            ['id'=>20,'year_id'=>6,'type'=>1], ['id'=>21,'year_id'=>6,'type'=>2],
            ['id'=>22,'year_id'=>6,'type'=>1], ['id'=>17,'year_id'=>9,'type'=>1],
            ['id'=>30,'year_id'=>2,'type'=>1],
        ]);
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication($app);
        $this->files = $this->createMock(Filesystem::class);
        $this->files->method('exists')->willReturnCallback(function ($path) {
            $this->reads[] = 'exists:'.$path;
            return array_key_exists($path, $this->contents);
        });
        $this->files->method('get')->willReturnCallback(function ($path) {
            $this->reads[] = 'get:'.$path;
            if (in_array($path, $this->unreadable, true)) throw new \RuntimeException('Isolated unreadable file');
            return $this->contents[$path];
        });
        foreach (['put', 'writeStream', 'delete', 'copy', 'move', 'makeDirectory', 'deleteDirectory', 'setVisibility'] as $method) {
            $this->files->expects($this->never())->method($method);
        }
        Storage::swap($this->files);
    }

    protected function tearDown(): void
    {
        $this->db->disconnect();
        \Illuminate\Database\Eloquent\Model::unsetConnectionResolver();
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication(null);
        \Illuminate\Container\Container::setInstance(null);
        parent::tearDown();
    }

    private function reader() { return new GradebookContextReader($this->files); }

    private function configure()
    {
        $this->contents['gradebook/409_6.json'] = json_encode(['lesson_id'=>'409','year_id'=>6,'components'=>[
            ['id'=>'legacy_homework','name'=>'Quiz','weight'=>'25','data_source'=>100,'sort_order'=>2],
            ['id'=>'legacy_exam','name'=>'Exam','weight'=>'50','data_source'=>'LEGACY_EXAM','max_mark'=>0.0],
            ['id'=>'dynamic_a','name'=>'Oral','weight'=>0,'data_source'=>'101','max_mark'=>10],
        ]]);
        $this->contents['gradebook_status/2_20.json'] = '{"status":"OPEN"}';
    }

    public function test_valid_legacy_config_and_status_agree_without_normalizing_mismatch()
    {
        $this->configure();
        $before = $this->contents;
        $legacy = GradebookConfigService::getConfig(409, 6)->all();
        $result = $this->reader()->resolve(new GradebookContext(6, 409, 20, 2, 132));
        $this->assertEquals($legacy, $result->components()->all());
        $this->assertSame(GradebookStatusService::getStatus(2, 20), $result->toArray()['status']['value']);
        $this->assertSame('valid', $result->toArray()['configuration']['state']);
        $this->assertSame(['legacy_id_source_mismatch'], $result->toArray()['configuration']['warnings']);
        $this->assertSame(100, $result->components()->first()->data_source);
        $this->assertSame('101', $result->components()->last()->data_source);
        $this->assertSame(0, $result->components()->last()->weight);
        $this->assertSame('sha256:'.hash('sha256', $before['gradebook/409_6.json']), $result->context()->configurationVersion());
        $this->assertSame($before, $this->contents);
    }

    public function test_missing_malformed_and_unreadable_files_are_different_from_valid_defaults()
    {
        foreach (['missing', 'invalid', 'unreadable'] as $state) {
            $this->contents = $state === 'missing' ? [] : ['gradebook/409_6.json'=>'{broken', 'gradebook_status/2_20.json'=>'{broken'];
            $this->unreadable = $state === 'unreadable' ? array_keys($this->contents) : [];
            $result = $this->reader()->resolve(new GradebookContext(6, 409, 20));
            $this->assertSame($state, $result->toArray()['configuration']['state']);
            $this->assertSame($state, $result->toArray()['status']['state']);
            $this->assertEquals(GradebookConfigService::getConfig(409, 6)->all(), $result->components()->all());
            if ($state !== 'unreadable') {
                $this->assertSame(GradebookStatusService::getStatus(2, 20), $result->toArray()['status']['value']);
            } else {
                $this->assertNull($result->toArray()['status']['value']);
            }
        }
    }

    public function test_structurally_invalid_and_unknown_status_values_are_flagged_not_normalized()
    {
        $this->contents['gradebook/409_6.json'] = '{"components":[{"id":"unchanged"}]}';
        $this->contents['gradebook_status/2_20.json'] = '{"status":"open"}';
        $result = $this->reader()->resolve(new GradebookContext(6, 409, 20));
        $this->assertSame('invalid', $result->toArray()['configuration']['state']);
        $this->assertEquals(GradebookConfigService::getConfig(409, 6)->all(), $result->components()->all());
        $this->assertSame('invalid', $result->toArray()['status']['state']);
        $this->assertSame('open', $result->toArray()['status']['value']);
    }

    public function test_terms_sections_and_timeline_are_exact_and_not_sorted_by_numeric_year_id()
    {
        foreach ([[6,20,132,'current'],[6,21,133,'current'],[6,22,132,'current'],
            [9,17,93,'historical'],[2,30,200,'future']] as $row) {
            [$year,$term,$room,$timeline] = $row;
            $result = $this->reader()->resolve(new GradebookContext($year, 409, $term, 2, $room));
            $this->assertSame($term, $result->context()->termId());
            $this->assertSame($room, $result->context()->roomId());
            $this->assertSame($timeline, $result->toArray()['timeline']);
        }
        $broad = $this->reader()->resolveLegacy(409, 6);
        $this->assertNull($broad->context()->termId());
        $this->assertSame('not_applicable', $broad->toArray()['status']['state']);
        $this->db->table('years')->where('id', 9)->update(['name'=>'Old year']);
        $this->assertSame('unresolved', $this->reader()->resolve(new GradebookContext(9,409))->toArray()['timeline']);
        $this->db->table('years')->update(['current_year'=>0]);
        $this->assertSame('unresolved', $this->reader()->resolveLegacy(409,6)->toArray()['timeline']);
        $this->db->table('years')->whereIn('id', [6,9])->update(['current_year'=>1]);
        $this->assertSame('unresolved', $this->reader()->resolveLegacy(409,6)->toArray()['timeline']);
    }

    public function test_wrong_academic_pairs_and_noninteger_ids_are_rejected()
    {
        foreach ([new GradebookContext(6,409,17), new GradebookContext(6,409,20,3),
            new GradebookContext(6,409,20,2,93), new GradebookContext(6,999)] as $context) {
            try { $this->reader()->resolve($context); $this->fail('Mismatched context accepted'); }
            catch (\InvalidArgumentException $e) { $this->assertNotEmpty($e->getMessage()); }
        }
        $this->expectException(\InvalidArgumentException::class);
        new GradebookContext('../6',409);
    }

    public function test_snapshot_and_context_are_immutable_defensive_copies()
    {
        $this->configure();
        $result = $this->reader()->resolve(new GradebookContext(6,409,20,2,132));
        $copy = $result->context()->toArray(); $copy['year_id'] = 99;
        $result->components()->first()->data_source = 'CHANGED';
        $array = $result->toArray(); $array['configuration']['state'] = 'changed';
        $this->assertSame(6, $result->context()->yearId());
        $this->assertSame(100, $result->components()->first()->data_source);
        $this->assertSame('valid', $result->toArray()['configuration']['state']);
    }

    public function test_future_backend_never_falls_back_and_conflicting_candidates_never_choose_first()
    {
        $this->configure();
        $a = new GradebookContext(6,409,20,2,132,'versioned_template','v1');
        $b = new GradebookContext(6,409,21,2,133,'versioned_template','v2');
        $unavailable = $this->reader()->resolve($a);
        $this->assertSame('backend_unavailable', $unavailable->toArray()['configuration']['state']);
        $this->assertCount(0, $unavailable->components());
        foreach ([[$a,$b],[$b,$a]] as $candidates) {
            try { $this->reader()->resolveLegacy(409,6,$candidates); $this->fail('Ambiguous versions accepted'); }
            catch (\DomainException $e) { $this->assertStringContainsString('Ambiguous', $e->getMessage()); }
        }
        $legacy = $this->reader()->resolveLegacy(409,6);
        $identity = $legacy->context();
        $this->assertEquals($legacy->components(), $this->reader()->resolveLegacy(409,6,[$identity,$identity])->components());
        $this->contents['gradebook/409_6.json'] .= ' ';
        $this->expectException(\DomainException::class);
        $this->reader()->resolve($identity);
    }

    public function test_read_baseline_is_select_only_bounded_and_does_not_probe_future_schema()
    {
        $this->configure();
        $this->db->enableQueryLog();
        $this->reads = [];
        $this->reader()->resolve(new GradebookContext(6,409,20,2,132));
        $log = $this->db->getQueryLog();
        $this->assertCount(6, $log);
        foreach ($log as $query) {
            $this->assertStringStartsWith('select', strtolower($query['query']));
            $this->assertStringNotContainsString('gradebook_applications', $query['query']);
        }
        $this->assertCount(4, $this->reads); // One exists + get per existing file.
    }
}
