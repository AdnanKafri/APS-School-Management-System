<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
   public function admin_sender(){ 
 
      
            // Relationship if admin_send_id is not null
            return $this->belongsTo(Adminstrator::class, 'admin_send_id');
       
 
   }
   
   
   
      public function admin_recv(){ 
  
           return $this->belongsTo(Adminstrator::class,'admin_recv_id');
        
   }
   
   
      
      public function recv_task_admin(){ 
  
           return $this->belongsTo(Adminstrator::class,'recv_id');
        
   }
   
   
        public function send_task_admin(){ 
  
           return $this->belongsTo(Adminstrator::class,'sender_id');
        
   }
   
   
   
           public function send_task_employee(){ 
  
           return $this->belongsTo(AdminEmployee::class,'sender_id');
        
   }
    
   
      
      public function employee_send(){ 
       return $this->belongsTo(AdminEmployee::class,'sender_id');

   }
   
         public function employee_recv(){ 
       return $this->belongsTo(AdminEmployee::class,'recv_id');

   }
   
   
   
   
    
}
