
                            function membervalue(memid)
                            {
                                document.getElementById('memberidvalue').value=memid;
                                document.memberidform.submit();
                            }

                            function changepage(pageno)
                            {
                                document.getElementById("page").value=pageno;
                                document.pagination.submit();
                            }
                            function validation(form)
                            {
                                alert("hai");
                                if(document.getElementById('name').value=='')
                                {
                                    alert("Enter Your Name");
                                    document.getElementById('name').focus();
                                    return false;
                                }
                                var comments=form.message.value;
                                if(comments.length==0)
                                {
                                    alert("Enter Your Message");
                                    form.message.focus();
                                    return false;
                                }
                                return true;
                            }


                            function GetXmlHttpObject()
                            {
                                if (window.XMLHttpRequest)
                                {
                                    // code for IE7+, Firefox, Chrome, Opera, Safari
                                    return new XMLHttpRequest();
                                }
                                if (window.ActiveXObject)
                                {
                                    // code for IE6, IE5
                                    return new ActiveXObject("Microsoft.XMLHTTP");
                                }
                                return null;
                            }


                            var xmlhttp;
                            var nocache = 0;
                            function insert() {
                                alert("cmd");
                                // document.getElementById('txt').style.display="none";
                                //  document.getElementById('initial').innerHTML=" ";
                                // Optional: Show a waiting message in the layer with ID login_response
                                //var msg=document.getElementById('insert_response').innerHTML = "Your comment has been posted successfully"

                                // Required: verify that all fileds is not empty. Use encodeURI() to solve some issues about character encoding.

                                var name= encodeURI(document.getElementById('name').value);
                                var message = encodeURI(document.getElementById('message').value);
                                var id= encodeURI(document.getElementById('id').value);

                                var category= encodeURI(document.getElementById('category').value);
                                var parentid= encodeURI(document.getElementById('parentvalue').value);


                                // Set te random number to add to URL request
                                nocache = Math.random();





                                xmlhttp=GetXmlHttpObject();
                                if (xmlhttp==null)
                                {
                                    alert ("Browser does not support HTTP Request");
                                    return;
                                }
                                document.getElementById('prcimg').style.display="block";
                                var url="index.php?option=com_contushdvideoshare&view=player&id="+id+"&category="+category+"&name="+name+"&message=" +message+"&pid="+parentid+"&nocache = "+nocache;
                                url=url+"&sid="+Math.random();

                                xmlhttp.onreadystatechange=stateChanged;
                                xmlhttp.open("GET",url,true);
                                xmlhttp.send(null);

                            }
                            function stateChanged()
                            {
                                if (xmlhttp.readyState==4)
                                {

                                    document.getElementById('prcimg').style.display="none";

                                    var name= document.getElementById('name').value;
                                    var message =document.getElementById('message').value;
                                    var id= encodeURI(document.getElementById('videoid').value);
                                    var boxid= encodeURI(document.getElementById('id').value);
                                    var category= encodeURI(document.getElementById('category').value);
                                    var parentid= encodeURI(document.getElementById('parentvalue').value);
                                    document.getElementById('name').disabled=true;
                                    document.getElementById('message').disabled=true;
                                    if(parentid==0)
                                    {
                                        document.getElementById("al").innerHTML="<div class='underline'></div><div class='clearfix'><div class='subhead changecomment'>"+name+" : <span></span></div></div><div>"+message+"</div>"+document.getElementById("al").innerHTML;
                                        commentcountval=document.getElementById('commentcount').innerHTML;
                                        document.getElementById('commentcount').innerHTML=parseInt(commentcountval)+1;
                                    }
                                    else
                                    {
                                        document.getElementById(parentid).innerHTML="<div class='clsreply'><div><strong>Re : <span>"+name+"</span></strong><div>"+message+"</div></blockquote>";
                                        commentcountval=document.getElementById('commentcount').innerHTML;
                                        document.getElementById('commentcount').innerHTML=parseInt(commentcountval)+1;
                                    }
                                    document.getElementById('txt').style.display="none";
                                    document.getElementById('initial').innerHTML=" ";
                                }
                            }
                            window.onload=function()
                            {
                                document.getElementById('txt').style.display="none";

                            }
                            function comments()
                            {
                                var d=document.getElementById('txt').innerHTML;
                                document.getElementById('initial').innerHTML=d;
                            }


                            function CountLeft(field, count, max)
                            {
                                // if the length of the string in the input field is greater than the max value, trim it
                                if (field.value.length > max)
                                    field.value = field.value.substring(0, max);
                                else
                                    count.value = max - field.value.length;
                            }
                            function textdisplay(rid)
                            {

                                if(document.getElementById('divnum').value>0 )
                                {
                                    document.getElementById(document.getElementById('divnum').value).innerHTML="";

                                }
                                document.getElementById('initial').innerHTML=" ";
                                var r=rid;
                                var d=document.getElementById('txt').innerHTML;
                                document.getElementById(r).innerHTML=d;
                                document.getElementById('txt').style.display="none";
                                document.getElementById('divnum').value=r;
                            }
                            function hidebox()
                            {
                                document.getElementById('txt').style.display="none";
                                document.getElementById('initial').innerHTML=" ";

                            }

                            function hiddinv()
                            {

                            }

                
