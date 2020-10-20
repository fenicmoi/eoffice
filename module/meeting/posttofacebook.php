<?php
 include_once 'src/facebook.php';
 
 $appId = '307433166271900';
 $secret = 'dfb3fa44d61107407c8587731a15fac1';
 $returnurl = 'http://localhost/posttofacebook';
 $permissions = 'manage_pages, publish_stream';
 
 $fb = new Facebook(array('appId'=>$appId, 'secret'=>$secret));
 
 $fbuser = $fb->getUser();
 
 if($fbuser){
 
    if(isset($_POST['msg']) and $_POST['msg']!=''){
        try{
            $message = array(
                'message' => $_POST['msg']
            );
            $posturl = '/'.$_POST['pageid'].'/feed';
            $result = $fb->api($posturl,'POST',$message);
            if($result){
                echo 'Successfully posted to Facebook Wall...';
            }
        }catch(FacebookApiException $e){
            echo $e->getMessage();
        }
    }
 
    try{
        $qry = 'select page_id, name from page where page_id in (select page_id from page_admin where uid ='.$fbuser.')';
        $pages = $fb->api(array('method' => 'fql.query','query' => $qry));
        
        if(empty($pages)){
            echo 'The user does not have any pages.';
        }else{
            echo '<form action="" method="post">';
            echo 'Select Page: <select name="pageid">';
            foreach($pages as $page){
                echo '<option value="'.$page['page_id'].'">'.$page['name'].'</option>';
            }
            echo '</select>';
            echo '<br />Message: <textarea name="msg"></textarea>';
            echo '<br /><input type="submit" value="Post to wall" />';
            echo '</form>';
        }
        
    }catch(FacebookApiException $e){
        echo $e->getMessage();
    }
    
 }else{
    $fbloginurl = $fb->getLoginUrl(array('redirect-uri'=>$returnurl, 'scope'=>$permissions));
    echo '<a href="'.$fbloginurl.'">Login with Facebook</a>';
 }
 
?>