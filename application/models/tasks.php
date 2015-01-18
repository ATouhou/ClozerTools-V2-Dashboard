<?php
class Tasks extends Eloquent
{
    public static $timestamps = true;
    public static $table = "tasks";

     public function sent_by()
    {
        return $this->belongs_to('User', 'sender_id');
    }

    public function sent_to()
    {
        return $this->belongs_to('User', 'receiver_id');
    }
}