<?php
class Message extends Eloquent
{
    public static $timestamps = true;
    public static $table="messages";

    public function sentby()
    {
        return $this->belongs_to('User', 'sender_id');
    }

    public function sentto()
    {
        return $this->belongs_to('User', 'receiver_id');
    }
}