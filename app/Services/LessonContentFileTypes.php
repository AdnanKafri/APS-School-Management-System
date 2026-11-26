<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

/** Private educational attachments, not executable uploads or a malware scanner. */
class LessonContentFileTypes
{
    public function formats(): array
    {
        $types = [];
        $add = function ($extensions, $kind, array $mimes) use (&$types) {
            foreach (explode(' ', $extensions) as $extension) $types[$extension] = ['kind'=>$kind,'mimes'=>$mimes];
        };
        $add('txt csv tsv sha256sum md markdown rst log ini conf cfg properties yaml yml tex bib cls sty srt vtt ass ssa', 'text', ['text/plain','text/csv','text/tab-separated-values','text/markdown','text/x-tex','text/x-bibtex','text/x-subrip','text/vtt','application/x-subrip','application/csv']);
        $add('html htm', 'source', ['text/html','text/plain']);
        $add('css scss sass less', 'source', ['text/css','text/plain','text/x-scss']);
        $add('js mjs cjs jsx tsx', 'source', ['application/javascript','text/javascript','text/plain','text/x-c','application/typescript','text/typescript']);
        $add('ts', 'source', ['application/javascript','text/javascript','text/plain','text/x-c','application/typescript','text/typescript','video/mp2t']);
        $add('php phps', 'source', ['text/x-php','application/x-php','text/plain','text/html']);
        $add('py java c cc cpp cxx h hpp cs sql sh bash bat cmd ps1 r rb go rs swift kt kts lua pl dart asm', 'source', ['text/plain','text/x-python','text/x-java','text/x-c','text/x-c++','text/x-csharp','text/x-script.python','text/x-shellscript','text/x-asm','text/x-ruby','application/x-shellscript','application/sql','text/x-sql','text/x-perl','text/x-msdos-batch','text/x-go']);
        $add('vue svelte','source',['text/plain','text/html']);
        $add('json ipynb gltf', 'source', ['application/json','text/plain']);
        $add('xml svg', 'source', ['application/xml','text/xml','text/plain','image/svg+xml','image/svg']);
        $add('pdf', 'pdf', ['application/pdf']);
        $add('rtf', 'rtf', ['application/rtf','text/rtf','text/plain']);
        $add('doc dot xls xlt ppt pot pps', 'ole', ['application/msword','application/vnd.ms-excel','application/vnd.ms-powerpoint','application/x-ole-storage','application/cdfv2','application/x-cdf','application/octet-stream']);
        $add('docx dotx docm dotm xlsx xltx xlsm xltm pptx potx ppsx pptm potm ppsm odt ods odp odg ott ots otp odf epub', 'package', ['application/zip','application/octet-stream','application/epub+zip','application/vnd.oasis.opendocument.text','application/vnd.oasis.opendocument.spreadsheet','application/vnd.oasis.opendocument.presentation','application/vnd.oasis.opendocument.graphics','application/vnd.oasis.opendocument.text-template','application/vnd.oasis.opendocument.spreadsheet-template','application/vnd.oasis.opendocument.presentation-template','application/vnd.oasis.opendocument.formula','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.openxmlformats-officedocument.wordprocessingml.template','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.openxmlformats-officedocument.spreadsheetml.template','application/vnd.openxmlformats-officedocument.presentationml.presentation','application/vnd.openxmlformats-officedocument.presentationml.template','application/vnd.openxmlformats-officedocument.presentationml.slideshow','application/vnd.ms-word.document.macroenabled.12','application/vnd.ms-word.template.macroenabled.12','application/vnd.ms-excel.sheet.macroenabled.12','application/vnd.ms-excel.template.macroenabled.12','application/vnd.ms-powerpoint.presentation.macroenabled.12','application/vnd.ms-powerpoint.template.macroenabled.12','application/vnd.ms-powerpoint.slideshow.macroenabled.12']);
        foreach (['jpg'=>'jpeg','jpeg'=>'jpeg','png'=>'png','gif'=>'gif','webp'=>'webp','tif'=>'tiff','tiff'=>'tiff'] as $ext=>$mime) $add($ext,'image',['image/'.$mime]);
        $add('bmp','image',['image/bmp','image/x-ms-bmp']); $add('ico','image',['image/x-icon','image/vnd.microsoft.icon']);
        $add('heic heif avif', 'image', ['image/heic','image/heif','image/avif','image/heic-sequence','image/heif-sequence','application/octet-stream']);
        $add('mp4 m4v', 'video', ['video/mp4','video/x-m4v']); $add('mov','video',['video/quicktime']);
        $add('webm','video',['video/webm']); $add('mkv','video',['video/x-matroska','application/x-matroska']);
        $add('avi','video',['video/x-msvideo','video/avi']); $add('wmv','video',['video/x-ms-wmv','video/x-ms-asf','application/vnd.ms-asf']);
        $add('mpeg mpg','video',['video/mpeg']); $add('3gp','video',['video/3gpp']); $add('ogv','video',['video/ogg','application/ogg']);
        $add('mts m2ts','video',['video/mp2t','application/octet-stream']);
        foreach (['mp3'=>['audio/mpeg'],'wav'=>['audio/wav','audio/x-wav','audio/vnd.wave'],'m4a'=>['audio/mp4','audio/x-m4a'],'aac'=>['audio/aac','audio/x-aac','audio/x-hx-aac-adts'],'ogg'=>['audio/ogg','application/ogg'],'opus'=>['audio/ogg','audio/opus','application/ogg'],'flac'=>['audio/flac','audio/x-flac'],'wma'=>['audio/x-ms-wma','audio/x-ms-asf','application/vnd.ms-asf'],'aif'=>['audio/x-aiff','audio/aiff'],'aiff'=>['audio/x-aiff','audio/aiff'],'mid'=>['audio/midi','audio/x-midi'],'midi'=>['audio/midi','audio/x-midi']] as $ext=>$mimes) $add($ext,'audio',$mimes);
        $add('zip','archive',['application/zip','application/x-zip-compressed']); $add('rar','archive',['application/x-rar','application/vnd.rar']);
        $add('7z','archive',['application/x-7z-compressed']); $add('tar','archive',['application/x-tar']);
        $add('gz tgz','archive',['application/gzip','application/x-gzip']); $add('bz2','archive',['application/x-bzip2']); $add('xz','archive',['application/x-xz']);
        $add('ttf otf woff woff2','font',['font/ttf','font/otf','font/sfnt','font/woff','font/woff2','application/x-font-ttf','application/x-font-opentype','application/font-sfnt','application/font-woff','application/octet-stream']);
        $add('eps ps ai','design',['application/postscript','application/pdf','text/plain']);
        $add('dxf','design',['image/vnd.dxf','image/x-dxf','application/dxf','application/x-dxf','text/plain','application/octet-stream']);
        $add('dwg','design',['image/vnd.dwg','image/x-dwg','application/acad','application/x-acad','application/octet-stream']);
        $add('stl','design',['model/stl','application/sla','application/octet-stream','text/plain']);
        $add('obj scad step stp','text',['text/plain','model/step','application/step']);
        $add('glb','design',['model/gltf-binary','application/octet-stream']);
        return $types;
    }

    public function inspect(UploadedFile $file): array
    {
        $extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
        $types = $this->formats();
        $path = $file->getRealPath(); $mime = strtolower((string)(new \finfo(FILEINFO_MIME_TYPE))->file($path));
        $handle = fopen($path,'rb');
        try { $head = fread($handle,65536); } finally { fclose($handle); }
        // Reject executable binaries even when renamed to an allowed extension.
        if (preg_match('/^(MZ|\x7fELF|\xca\xfe\xba\xbe|\xcf\xfa\xed\xfe|\xfe\xed\xfa\xcf|\xce\xfa\xed\xfe|\xfe\xed\xfa\xce)/s', $head)
            || !isset($types[$extension]) || !in_array($mime,$types[$extension]['mimes'],true)) $this->reject();
        $kind = $types[$extension]['kind'];
        if ($extension === 'ts' && $mime === 'video/mp2t') $kind = 'video';
        $unicodeBom = in_array(substr($head,0,2),["\xff\xfe","\xfe\xff"],true) || substr($head,0,4)==="\0\0\xfe\xff";
        if (in_array($kind,['text','source'],true) && strpos($head,"\0") !== false && !$unicodeBom) $this->reject();
        if ($extension === 'svg' && !preg_match('/<svg(?:\s|>)/i',str_replace("\0",'',$head))) $this->reject();
        if ($kind === 'rtf' && strpos($head,'{\\rtf') !== 0) $this->reject();
        if ($kind === 'ole' && substr($head,0,8) !== "\xd0\xcf\x11\xe0\xa1\xb1\x1a\xe1") $this->reject();
        if ($kind === 'package' || $extension === 'zip') $mime = $this->package($file,$extension,$mime);
        $this->signature($extension,$kind,$head,$file->getSize());
        // Active formats are opaque private blobs even if a hosting alias is misconfigured.
        $opaque = in_array($kind,['source','text','ole','package','archive','font','design','rtf'],true)
            && !in_array($extension,['txt','csv','sha256sum','docx','xlsx','pptx'],true);
        return ['mime_type'=>$mime,'extension'=>$opaque ? 'bin' : ($extension === 'sha256sum' ? 'txt' : $extension), 'kind'=>$kind];
    }

    private function reject()
    {
        LessonContentInput::reject(__('lesson_content.invalid_type'));
    }

    private function package($file,$extension,$mime)
    {
        $zip = new \ZipArchive(); if ($zip->open($file->getRealPath()) !== true) $this->reject();
        try {
            if ($zip->numFiles > 10000) $this->reject();
            $bytes = 0; $macro = false;
            for ($i=0;$i<$zip->numFiles;$i++) {
                $s=$zip->statIndex($i); if (!$s || !empty($s['encryption_method'])) $this->reject();
                $name=$s['name']; $bytes += $s['size'];
                if ($bytes > 8 * 1073741824 || preg_match('~(^/|^[a-z]:|(^|/)\.\.(/|$)|\\\\|\x00|\.(exe|dll|com|scr|msi|apk|jar)$)~i',$name)) $this->reject();
                if (stripos($name,'vbaproject') !== false) $macro = true;
            }
            if ($extension === 'zip') return $mime;
            if (in_array($extension,['odt','ods','odp','odg','ott','ots','otp','odf','epub'],true)) {
                $s=$zip->statName('mimetype'); if (!$s || $s['size'] > 256) $this->reject();
                $expected=['odt'=>'text','ods'=>'spreadsheet','odp'=>'presentation','odg'=>'graphics','ott'=>'text-template','ots'=>'spreadsheet-template','otp'=>'presentation-template','odf'=>'formula'];
                $expected=$extension==='epub'?'application/epub+zip':'application/vnd.oasis.opendocument.'.$expected[$extension];
                if ($zip->getFromName('mimetype',256) !== $expected || $zip->locateName($extension==='epub'?'META-INF/container.xml':'content.xml') === false) $this->reject();
                return $expected;
            }
            $main = in_array($extension,['docx','dotx','docm','dotm'],true) ? 'word/document.xml'
                : (in_array($extension,['xlsx','xltx','xlsm','xltm'],true) ? 'xl/workbook.xml' : 'ppt/presentation.xml');
            if ($zip->locateName('[Content_Types].xml') === false || $zip->locateName($main) === false) $this->reject();
            if ($macro && !in_array($extension,['docm','dotm','xlsm','xltm','pptm','potm','ppsm'],true)) $this->reject();
            if (!in_array($extension,['docm','dotm','xlsm','xltm','pptm','potm','ppsm'],true)) {
                for ($i=0;$i<$zip->numFiles;$i++) if (preg_match('/\.js$/i',$zip->getNameIndex($i))) $this->reject();
            }
            if (in_array($extension,['docx','xlsx','pptx'],true)) return ['docx'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document','xlsx'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','pptx'=>'application/vnd.openxmlformats-officedocument.presentationml.presentation'][$extension];
            return 'application/octet-stream';
        } finally { $zip->close(); }
    }

    private function signature($ext,$kind,$head,$size)
    {
        $ok = true;
        if (in_array($ext,['heic','heif','avif','mp4','m4v','mov','m4a','3gp'],true)) $ok = substr($head,4,4)==='ftyp' || ($ext==='mov' && in_array(substr($head,4,4),['moov','mdat','wide'],true));
        if (in_array($ext,['heic','heif','avif'],true)) $ok = $ok && preg_match($ext==='avif'?'/avif|avis/':'/heic|heix|hevc|hevx|mif1|msf1/',substr($head,8,64));
        if (in_array($ext,['webm','mkv'],true)) $ok = substr($head,0,4)==="\x1a\x45\xdf\xa3";
        if (in_array($ext,['mts','m2ts'],true) || ($ext==='ts' && $kind==='video')) $ok = (isset($head[376]) && $head[0]==="\x47" && $head[188]==="\x47" && $head[376]==="\x47") || (isset($head[388]) && $head[4]==="\x47" && $head[196]==="\x47" && $head[388]==="\x47");
        if ($ext==='rar') $ok = substr($head,0,6)==="Rar!\x1a\x07";
        if ($ext==='7z') $ok = substr($head,0,6)==="7z\xbc\xaf\x27\x1c";
        if (in_array($ext,['gz','tgz'],true)) $ok = substr($head,0,2)==="\x1f\x8b";
        if ($ext==='bz2') $ok = substr($head,0,3)==='BZh';
        if ($ext==='xz') $ok = substr($head,0,6)==="\xfd7zXZ\0";
        if (in_array($ext,['ttf','otf','woff','woff2'],true)) $ok = in_array(substr($head,0,4),['OTTO',"\0\x01\0\0",'true','ttcf','wOFF','wOF2'],true);
        if ($ext==='dwg') $ok = preg_match('/^AC10[0-9]{2}/D',$head)===1;
        if ($ext==='glb') $ok = substr($head,0,4)==='glTF';
        if ($ext==='stl') $ok = strpos($head,'solid')===0 || (strlen($head)>=84 && 84 + 50 * unpack('V',substr($head,80,4))[1] === $size);
        if (!$ok) $this->reject();
    }

    public function inline($mime,$originalName): bool
    {
        $extension = strtolower(pathinfo($originalName,PATHINFO_EXTENSION)); $types=$this->formats();
        if (!isset($types[$extension]) || !in_array(strtolower($mime),$types[$extension]['mimes'],true)) return false;
        return in_array($types[$extension]['kind'],['video','audio','image','pdf'],true)
            || ($extension==='ts' && $mime==='video/mp2t');
    }
}
