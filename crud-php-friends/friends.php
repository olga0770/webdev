<form action="friends.php" method="post">
    <input type="text" placeholder="friend name" name="txtNameInsert">
    <input type="submit" name="submit" value="Add Friend">
</form>

<?php

$sPageTitle = 'Friends';
$sPageColor = '#F5F5DC';
require_once 'components/top.php';

$sData = file_get_contents('data.txt');
$jData = json_decode($sData, true);
if (empty($jData)) {
    //print "initializing array...<br>";
    $jData = array();
}
else {
    //print "length of array: ". count($jData) . "<br>";
}

if( !empty($_POST['txtNameUpdate'])){
    // we are updating here
    //print "we are updating...<br>";

    $sId = $_GET['friend_id'];
    $sName = $_POST['txtNameUpdate'];

    $jData[$sId]['name'] = $sName;
    $sData = json_encode($jData);
    file_put_contents('data.txt', $sData);
}

if( !empty($_POST['txtNameInsert'])){
    // we are adding friend here
    //print "we are inserting...<br>";

    $sId = uniqid();
    $sName = $_POST['txtNameInsert'];
    
    // print "unique id: $sId <br>";
    // print "name entered: $sName <br>";
    
    $jData[$sId]['name'] = $sName;
    $sData = json_encode($jData);
    file_put_contents('data.txt', $sData);
}

$sFriendDiv = '<div class="friend">
<form action="friends.php?friend_id={id}" method="POST">
    <input type="text" value="{name}" name="txtNameUpdate">
    <button>Update</button>
    <div>
</form>  
</div>';

// show all data on the page
if (!empty($jData)) {
    foreach($jData as $sId => $jFriend){
        $sTempFriend = $sFriendDiv;
        $sTempFriend = str_replace('{id}', $sId, $sTempFriend);
        $sTempFriend = str_replace('{name}', $jFriend['name'], $sTempFriend);
        echo $sTempFriend;
    }
}


require_once 'components/bottom.php';
?>
