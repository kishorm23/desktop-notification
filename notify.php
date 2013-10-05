<?php

function is_connected()
{
    $connected = @fsockopen("www.google.com", 80);
    if ($connected){
        $is_conn = true;
        fclose($connected);
    }else{
        $is_conn = false;
    }
    return $is_conn;

}

while(!is_connected());

exec("export DISPLAY=:0;notify-send \"Notification\" \"Facebook notification daemon started.\"");

require_once('inc/facebook.php');
require_once('config.php');

$facebook = new Facebook($config);

echo "get limit 3 notifications";

$arg1 = array(
 'limit' => '3',
 'access_token' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'
);

$arg2 = array(
 'access_token' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'
);
$i=0;
while(1)
{
    $data = $facebook->api('/me/notifications','GET',$arg1);

    $message = $facebook->api('/me/inbox','GET',$arg2);
    $inbox=$message['data'];
    $arrays = $data['data'];
    //print_r($inbox);
    echo "count size: ".count($arrays);
    foreach ($arrays as &$value) {
    print_r($value);
    echo "Facebook Notification<br>";
    echo "From: ".$value['from']['name']."<br>";
    echo "To: ".$value['to']['name']."<br>";
    echo "Updated time: ".$value['updated_time']."<br>";
    echo "Title: ".$value['title']."<br>";
    echo "Link: ".$value['link'];
    $from=$value['from']['name'];
    $title = $value['title'];
    $title = str_replace(array('\'', '"'), '', $title); 
    exec("notify-send -t 0 \"Notification: $title\" \"$from \n$title\"");
    $args1 = array(
    'unread' =>'false');
    $facebook->api('/'.$value['id'].'?unread=false','POST',$args);
}

    foreach ($inbox as &$value) 
    {
        foreach ($value['comments']['data'] as &$index) 
            {
                if($index['from']['id']!=$facebook->getUser()&&$value['unseen']!=0) $name=$index['from']['name'];
            }
    if($value['unseen']!=0&&$name!="") 
    {
        echo "You have ".$value['unseen']." unseen message(s) from ".$name; 
        exec("notify-send \"Message: You have ".$value['unseen']." unseen message(s) from \" \"$name\" ");
    }
  }
  /**************check for email************************/

if($i==0)
{
    $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
    $username = 'xxxxxxxxx@gmail.com';
    $password = 'xxxxxxxxxxxxxxxxxxxxxxxxx';

    $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
    $emails = imap_search($inbox,'ALL');

    if($emails) 
    {
        rsort($emails);
        
        for($i=9;$i>=0;$i--)
        {
            $overview = imap_fetch_overview($inbox,$emails[$i],0);
            if($overview[0]->seen==0) exec("notify-send \"Gmail\" \"".$overview[0]->subject."\"");
        }
    }
    $i++;
}

imap_close($inbox);
sleep(60);
}

?>
