

$( document ).ready(function() {
 // console.log(posts_json);

  $( ".search_btn" ).on( "click", function() {
	  
	  var search_word = $(".search_txt").val();
	  var post_links = find_posts(search_word,posts_json);
	  $(".search_res").html(post_links);
	  
  });
});

function find_posts(search_word,data)
{
  var ret = "";
  var regex = new RegExp(search_word, "i");
  for (var val of data) 
  {
	if ((val.title.search(regex) != -1) || (val.content.search(regex) != -1))
	{
		console.log(val);
		ret += "<li class='search_item_li'><a class='btn' href='./posts/"+val.title+"/index.html'>"+val.title+"</a></li>";
		//ret.push(val);
	}
  }
  return ret;
}

