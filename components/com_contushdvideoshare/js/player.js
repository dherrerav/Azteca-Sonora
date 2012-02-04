 function loadifr()
    {
        ev = document.getElementById('myframe1');
        if(ev!=null)
        {
            setHeight(ev);
            addEvent(ev,'load', doIframe);
        }
    }
    function ratecal(rating,ratecount,views)
    {
        //alert(views);
        if(document.getElementById('viewid'))
        {
            document.getElementById('viewid').innerHTML="<b><h3 style='text-align:right'><?php echo _HDVS_VIEWS; ?> : "+views+"</h3></b>";
        }
        rating=Math.round(rating/ratecount);

        if(rating==1)
            document.getElementById('rate').className="ratethis onepos";
        else if(rating==2)
            document.getElementById('rate').className="ratethis twopos";
        else if(rating==3)
            document.getElementById('rate').className="ratethis threepos";
        else if(rating==4)
            document.getElementById('rate').className="ratethis fourpos";
        else if(rating==5)
            document.getElementById('rate').className="ratethis fivepos";
        else
            document.getElementById('rate').className="ratethis nopos";
        document.getElementById('ratemsg').innerHTML="Ratings :"+ratecount;


    }
     function createObject()
        {
            var request_type;
            var browser = navigator.appName;
            if(browser == "Microsoft Internet Explorer")
            {
                request_type = new ActiveXObject("Microsoft.XMLHTTP");
            }
            else
            {
                request_type = new XMLHttpRequest();
            }
            return request_type;
        }
        var http = createObject();
        var nocache = 0;
        nocache = Math.random();
        http.open('get', 'index.php?option=com_contushdvideoshare&view=player&id='+id+'&nocache = '+nocache,true);
        http.onreadystatechange = insertReply;
        http.send(null);
        function insertReply()
        {
            if(http.readyState == 4)
            {
                var url="";
                if(document.getElementById('commentoption'))
                {
                    var cmdoption=document.getElementById('commentoption').value;
                    if( cmdoption==2 || cmdoption==3)
                    {

                        url= 'index.php?option=com_contushdvideoshare&view=commentappend&id='+id+'&cmdid='+cmdoption;
                        document.getElementById('myframe1').src=url;
                        document.getElementById('myframe1').style.display="block";

                    }
                    if(cmdoption!=0 && cmdoption!=2 && cmdoption!=3)
                    {
                        url= 'index.php?option=com_contushdvideoshare&view=commentappend&id='+id+'&cmdid='+cmdoption;
                        commentappendfunction(url);
                    }
                }

            }
        }

        ratecal(rating,ratecount,views);

    function commentappendfunction(url)
    {
        function createObject()
        {
            var xmlhttp;
            var browser = navigator.appName;
            if(browser == "Microsoft Internet Explorer")
            {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            else
            {
                xmlhttp = new XMLHttpRequest();
            }
            return xmlhttp;
        }
        xmlhttp = createObject();
        var nocache = 0;
        nocache = Math.random();
        url= url+'&nocache = '+nocache;
        xmlhttp.onreadystatechange=stateChanged;
        xmlhttp.open("GET",url,true);
        xmlhttp.send(null);

    }

    function stateChanged()
    {
        if (xmlhttp.readyState==4)
        {
            document.getElementById("commentappended").innerHTML=xmlhttp.responseText;
            document.getElementById("commentappended").style.display="block";

        }
    }
    function resethomepagerate()
    {

        document.getElementById('ratemsg').innerHTML="<?php echo _HDVS_RATTING; ?> : "+document.getElementById('storeratemsg').value;
    }
