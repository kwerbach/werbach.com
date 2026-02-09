// Use this function to retrieve a cookie.
function get_cookie(name)
{
	var cname = name + "=";               
	var dc = document.cookie;             
		if (dc.length > 0) {              
		begin = dc.indexOf(cname);       
			if (begin != -1) {           
			begin += cname.length;       
			end = dc.indexOf(";", begin);
				if (end == -1) end = dc.length;
				return unescape(dc.substring(begin, end));
			} 
		}
	return '';
}

// Use this function to save a cookie.
function set_cookie(name, value, mins) 
{
  var expire = "";
  if(mins != null)
  {
    expire	= new Date((new Date()).getTime() + mins * 60000);
    expire	= "; expires=" + expire.toGMTString();
	path	= "; path=/";
  }
  document.cookie = name + "=" + escape(value) + expire + path;
}


				function hideShow(obj)
				{
					src_elem = ("#" + obj)
					var target_elem = "#text_" + obj;
				     $(target_elem).toggle("medium", function()
					 	{
							if( $(src_elem).text() == "+" )
							{
								$(src_elem).text("-")
							}
							else
							{
								$(src_elem).text("+")
							}
						 }
					);	 
					 				 
				}