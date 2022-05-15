<?php

function yheader($src)
{
	echo'<script>window.location="'.$src.'";</script>';
}

function chackboxr_from_sql($arr,$name,$field,$checked_idsr=array(),$req=0)
{
	$ret = array();
	foreach($arr as $row)
	{
		if(in_array($row["id"],$checked_idsr))
		{
			
			$ret[] = array('value'=>$row["id"],'name'=>$name,'required'=>$req
			,'label'=>$row[$field],'checked'=> 1);
		}
		else{
			$ret[] = array('value'=>$row["id"],'name'=>$name,'required'=>$req
			,'label'=>$row[$field],'checked'=> 0);
		}
	}
	return $ret;
}//end chackboxr_from_sql


function ypagination($base_url,$entries,$per_page,$current_page=1)
{
	$html = "";
	$html .= "";
	return $html;
}//end ypagination

function array_remove_num_keys($arr)
{
	foreach ($arr as $key => $value) {
		if (is_int($key)) {
			unset($arr[$key]);
		}
	}
	return $arr;
}//end array_remove_num_keys

function array_remove_num_keys2d($arr)
{
	foreach ($arr as $key =>$row) {
		foreach ($row as $key2 => $value) {
			if (is_int($key2)) {
				unset($arr[$key][$key2]);
			}
		}
	}
	return $arr;
}//end array_remove_num_keys


function save_file($folderPath,$filename,$filecontent){
    if (strlen($filename)>0){
        if(!isset($folderPath)){$folderPath = 'temp';}
        if (!file_exists($folderPath)) {
            mkdir($folderPath);
        }
        $file = @fopen($folderPath . DIRECTORY_SEPARATOR . $filename,"w");
        if ($file != false){
            fwrite($file,$filecontent);
            fclose($file);
            return 1;
        }
        return -2;
    }
    return -1;
}

function ycreate_blog_html_file($title,$content,$date)
{
	$view = new Template(); 
	$view->title = $title; 
	$view->content = $content; 
	$view->ydate = $date; 
	$html =  $view->render('./templates/main_export.ytpl'); 
	
	return save_file("export_html/posts/".$title,"index.html",$html);
}//end ycreate_blog_html_file



function yget_setting($arr,$name)
{
	foreach($arr as $row)
	{
		if($row['name'] == $name){return $row['value'];}
	}
	return false;
}//end yget_setting


function ymake_index_page($posts,$cats,$settings)
{
	$site_title = yget_setting($settings,"blog_name");
	$blog_top_copy = yget_setting($settings,"blog_top_copy");
	
	$view = new Template(); 
	$view->title = $site_title; 
	$view->blog_top_copy = $blog_top_copy; 
	$view->cats = $cats; 
	$view->posts = $posts; 
	$html =  $view->render('./templates/export_index.ytpl');
	save_file("export_html/","index.html",$html);
	
}//end ymake_index_page

function ymake_search_page()
{	
	$view = new Template(); 
 
	$html =  $view->render('./templates/‏‏export_search.ytpl');
	save_file("export_html/","search.html",$html);

}//end ymake_search_page

function ymake_about_page($settings)
{
	$site_title = yget_setting($settings,"blog_name");
	$about_img = yget_setting($settings,"about_page_img_url");;
	$about_txt = yget_setting($settings,"about_page_txt");;
	
	$view = new Template(); 
	$view->title = $site_title; 
	$view->about_page_img_url = $about_img; 
	$view->about_page_txt = $about_txt; 
	$html =  $view->render('./templates/‏‏export_about.ytpl');
	save_file("export_html/","about.html",$html);

}//end ymake_about_page

function ymake_cats_page($cats)
{
	$view = new Template(); 
	$view->title = "categories"; 
	$view->cats = $cats; 
	$html =  $view->render('./templates/export_all_cats.ytpl');
	save_file("export_html/","categories.html",$html);
}//end ymake_cats_page

function ymake_cats_pages($cats,$posts)
{
	foreach($cats as $cat)
	{
		//get single cat data,name id and posts (for posts links)
		$cat_name = $cat['name'];
		$cid =  $cat['id'];
		$cat_posts = array();
		foreach($posts as $post)
		{
			//if cat is in post cat ids
			if(strpos($post['cats_ids'],$cid) !== false)
			{
				//add it to $cat_posts
				array_push($cat_posts,$post);
			}
		}//end foreach posts
		//create page
		
		$view = new Template(); 
		$view->title = $cat_name; 
		$view->cat_posts = $cat_posts; 
		$html =  $view->render('./templates/export_cat.ytpl');
		save_file("export_html/category",$cat_name.".html",$html);	
	}//end foreach cats
}//end ymake_cats_pages

?>