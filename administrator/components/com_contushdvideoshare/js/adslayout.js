
    if((document.getElementById('fileoption').value == 'File') || (document.getElementById('fileoption').value == ''))
    {
        adsflashdisable();

    }
    if(document.getElementById('fileoption').value == 'Url')
    {
        urlenable();

    }
 
    function urlenable()
    {
        document.getElementById('postrollnf').style.display='none';
        document.getElementById('postrollurl').style.display='';
    }
    function adsflashdisable()
    {
        document.getElementById('postrollnf').style.display='';
        document.getElementById('postrollurl').style.display='none';
    }
    function fileads(filepath)
    {
        if(filepath=="File")
        {
            adsflashdisable();
            document.getElementById('fileoption').value='File';
        }
        if(filepath=="Url")
        {
            urlenable();
            document.getElementById('fileoption').value='Url';
        }

    }
    function submitbutton(pressbutton)
    {
        if (pressbutton == "saveads" || pressbutton=="applyads")
        {
            var bol_file1=(document.getElementById('filepath01').checked);
            if (document.getElementById('adsname').value == "")
            {
                alert( "You must provide a Title" )
                return;
            }

            if(bol_file1==true)
            {
                document.getElementById('fileoption').value="File"
                if(uploadqueue.length!="")
                {
                    alert("Upload in Progress");
                    return;
                }
                if(document.getElementById('id').value=="")
                {
                    if(document.getElementById('normalvideoform-value').value=="")
                    {
                        alert("You must Upload a file");
                        return;
                    }
                }
            }
            if(bol_file1==false)
            {

                document.getElementById('fileoption').value="Url"
                if(document.getElementById('posturl').value=="")
                {
                    alert( "You must provide a Video Url" )
                    return;
                }
                if(document.getElementById('posturl').value!="")
                {
                    document.getElementById('posturl-value').value=document.getElementById('posturl').value;
                }
            }
            submitform( pressbutton );
            return;
        }
        submitform( pressbutton );
        return;

    }
    