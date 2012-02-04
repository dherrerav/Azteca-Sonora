 document.getElementById('fileoption').value='File';
    document.getElementById('streameroption1').checked==true;
    document.getElementById('stream1').style.display='none';
    document.getElementById('postroll').style.display='none';
    document.getElementById('preroll').style.display='none';


    if(document.getElementById('prerollads').checked==1)
       preroll(1);
    else
       preroll(0) ;

    if(document.getElementById('postrollads').checked==1)
       postroll(1);
    else
       postroll(0) ;


    if(document.getElementById('mode1').value == 'Youtube')
    {
        withoutflashhide();
        urlvisible();
        document.getElementById('ffmpeg_disable_new6').style.display="none";
        document.getElementById('ffmpeg_disable_new7').style.display="none";
        document.getElementById('ffmpeg_disable_new8').style.display="none";
        document.getElementById('fvideos').style.display="none";
    }
if(document.getElementById('mode1').value == 'Vimeo')
    {
        withoutflashhide();
        urlvisible();
        document.getElementById('ffmpeg_disable_new6').style.display="none";
        document.getElementById('ffmpeg_disable_new7').style.display="none";
        document.getElementById('ffmpeg_disable_new8').style.display="none";
        document.getElementById('fvideos').style.display="none";
        
    }
    if(document.getElementById('mode1').value == 'File')
    {
        withoutflashvisible();
        urlhide();
        document.getElementById('fvideos').style.display="none";
    }

    if(document.getElementById('mode1').value == 'FFmpeg')
    {

        urlhide();
        document.getElementById('fvideos').style.display="";
    }
    if(document.getElementById('mode1').value == 'Url')
    {

        if(document.getElementById('streameroption-value').value=="rtmp")
        document.getElementById('stream1').style.display='';

        withoutflashhide();
        urlvisible();
        document.getElementById('fvideos').style.display="none";
    }
    if(document.getElementById('mode1').value == '')
    {

        withoutflashvisible();
        urlhide();
        document.getElementById('fvideos').style.display="none";
    }
    function urlhide()
    {

        document.getElementById('ffmpeg_disable_new5').style.display="none";
        document.getElementById('ffmpeg_disable_new6').style.display="none";
        document.getElementById('ffmpeg_disable_new7').style.display="none";
        document.getElementById('ffmpeg_disable_new8').style.display="none";

    }

    function urlvisible()
    {
        document.getElementById('ffmpeg_disable_new5').style.display="";
        document.getElementById('ffmpeg_disable_new6').style.display="";
        document.getElementById('ffmpeg_disable_new7').style.display="";
        document.getElementById('ffmpeg_disable_new8').style.display="";
    }

    function withoutflashhide()
    {
        document.getElementById('ffmpeg_disable_new1').style.display="none";
        document.getElementById('ffmpeg_disable_new2').style.display="none";
        document.getElementById('ffmpeg_disable_new3').style.display="none";
        document.getElementById('ffmpeg_disable_new4').style.display="none";
    }

    function withoutflashvisible()
    {
        document.getElementById('ffmpeg_disable_new1').style.display="";
        document.getElementById('ffmpeg_disable_new2').style.display="";
        document.getElementById('ffmpeg_disable_new3').style.display="";
        document.getElementById('ffmpeg_disable_new4').style.display="";
    }

    function fileedit(file_var)
    {
        if(file_var=='File')
        {
            withoutflashvisible();
            urlhide();
            document.getElementById('fvideos').style.display="none";
            document.getElementById('fileoption').value='File';
        }
        else if(file_var=='Url')
        {
            withoutflashhide();
            urlvisible();
            document.getElementById('fvideos').style.display="none";
            document.getElementById('fileoption').value='Url';
        }
        else if(file_var=='Youtube')
        {
            withoutflashhide();
            urlvisible();
            document.getElementById('ffmpeg_disable_new6').style.display="none";
            document.getElementById('ffmpeg_disable_new7').style.display="none";
            document.getElementById('ffmpeg_disable_new8').style.display="none";
            document.getElementById('fvideos').style.display="none";
            document.getElementById('fileoption').value='Youtube';
            document.getElementById('preroll-ad').style.display="";
            document.getElementById('postroll-ad').style.display="";
            document.getElementById('download').style.display="";
            document.getElementById('target').style.display="";
            
        }
        else if(file_var=='Vimeo')
        {
            withoutflashhide();
            urlvisible();
            document.getElementById('ffmpeg_disable_new6').style.display="none";
            document.getElementById('ffmpeg_disable_new7').style.display="none";
            document.getElementById('ffmpeg_disable_new8').style.display="none";
            document.getElementById('fvideos').style.display="none";
            document.getElementById('preroll-ad').style.display="none";
            document.getElementById('postroll-ad').style.display="none";
            document.getElementById('download').style.display="none";
            document.getElementById('target').style.display="none";
            document.getElementById('fileoption').value='Youtube';
        }
        else if(file_var=='FFmpeg')
        {
            withoutflashhide();
            urlhide();
            document.getElementById('fvideos').style.display="";
            document.getElementById('fileoption').value='FFmpeg';
        }
    }

    function streamer1(streamername)
    {
        // alert(streamername);
        if(streamername=="None")
        {
            document.getElementById('stream1').style.display='none';
            document.getElementById("filepath1").checked=true;
            document.getElementById("filepath1").disabled=false;
            document.getElementById("filepath3").disabled=false;
            document.getElementById("filepath4").disabled=false;
            document.getElementById('fileoption').value='File';
            withoutflashvisible();
            urlhide();
             document.getElementById('ffmpeg_disable_new8').style.display='';
        }

        if(streamername=="lighttpd")
        {
            document.getElementById('stream1').style.display='none';
            document.getElementById("filepath2").checked=true;
            document.getElementById("filepath1").disabled=true;
            document.getElementById("filepath3").disabled=true;
            document.getElementById("filepath4").disabled=true;
            document.getElementById('fileoption').value='Url';
            withoutflashhide();
            urlvisible();
             document.getElementById('ffmpeg_disable_new8').style.display='none';
        }
        else if(streamername=="rtmp")
        {
            document.getElementById('stream1').style.display='';
            document.getElementById("filepath2").checked=true;
            document.getElementById("filepath1").disabled=true;
            document.getElementById("filepath3").disabled=true;
            document.getElementById("filepath4").disabled=true;
            document.getElementById('fileoption').value='Url';
            withoutflashhide();
            urlvisible();
             document.getElementById('ffmpeg_disable_new8').style.display='none';
        }

    }

    function getValue1()
    {
        var var_up1;

        var_up1='<input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" /><input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />';
        document.getElementById('var_up1').innerHTML=var_up1;

    }
    function getValue2()
    {
        var var_up2;
        //var_up2='<input type="file" name="videourl" id="videourl" maxlength="100"  value="" /><label style="background-color:#D5E9EE; color:#333333;">Allowed Extensions :FLV,MP3, MP4, M4V, M4A, MOV, Mp4v, F4V</label>';
        var_up2='<input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" /><input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />';
        document.getElementById('fvideos').value='1';
        document.getElementById('var_up2').innerHTML=var_up2;
    }
    function getValue3()
    {
        var var_up3;
        //var_up3='<input type="file" name="thumburl" id="thumburl" maxlength="100"  value="" /><label style="background-color:#D5E9EE; color:#333333;">Allowed Extensions :.jpg,.png,.gif </label>';
        var_up3='<input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" /><input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />';
        document.getElementById('fthumb').value='1';
        document.getElementById('var_up3').innerHTML=var_up3;
    }
    function getValue4()
    {
        var var_up4;
        var_up4='<input type="file" name="previewurl" id="previewurl" maxlength="100"  value="" /><label style="background-color:#D5E9EE; color:#333333;">Allowed Extensions :.jpg,.png,.gif</label>';
        document.getElementById('fpreview').value='1';
        document.getElementById('var_up4').innerHTML=var_up4;
    }

    function getValue5()
    {
        var var_up5;
        var_up5='<input type="file" name="hdurl" id="hdurl" maxlength="100"  value="" /><label style="background-color:#D5E9EE; color:#333333;">Allowed Extensions :FLV,MP3, MP4, M4V, M4A, MOV, Mp4v, F4V </label>';
        document.getElementById('fhd').value='1';
        document.getElementById('var_up5').innerHTML=var_up5;
    }

    function postroll(postvalue)
    {
        if(postvalue==0)
            document.getElementById("postroll").style.display='none';
        if(postvalue==1)
            document.getElementById("postroll").style.display='';
    }

     function preroll(prevalue)
    {
        if(prevalue==0)
            document.getElementById("preroll").style.display='none';
        if(prevalue==1)
            document.getElementById("preroll").style.display='';
    }

      function select_alphabet(playlistbyalphabets)
    {

        var rad_val_all = '';
        var rad_val_alphabet = '';
        document.getElementById('playlistid').innerHTML="";

        var final_array=new Array();
        var v_array1 = ["A", "B", "C", "D", "E","F","a","b","c","d","e","f"];
        var v_array2 = ["G", "H", "I", "J", "K","L","g","h","i","j","k","l"];
        var v_array3 = ["M", "N", "O", "P", "Q","R","m","n","o","p","q","r"];
        var v_array4 = ["S", "T", "U", "V", "s","t","u","v"];
        var v_array5 = ["W", "X", "Y", "Z", "w","x","y","z"];




        for (var i=0; i < document.getElementsByName('displayplaylist').length; i++)
        {
            if (document.getElementsByName('displayplaylist')[i].checked)
            {
                rad_val_all = document.getElementsByName('displayplaylist')[i].value;
            }
        }

        for (var j=0; j < document.getElementsByName('playliststart').length; j++)
        {
            if (document.getElementsByName('playliststart')[j].checked)
            {
                rad_val_alphabet = document.getElementsByName('playliststart')[j].value;
            }
        }
        if(rad_val_all == 2)
        {
            if(user.length>25)
                total_length=25;
            else
                total_length=user.length;

            final_array = user;
            final_array.sort();

        }
        else
        {
            total_length=user.length;
            final_array=user;
            final_array.sort();
        }

n=0;
        for (var m = 0; m < total_length; m++)


        {
            if(rad_val_alphabet == 'AF')
            {
                first_letter = final_array[m][0];
                first_letter1 = first_letter.charAt(0);
                if(v_array1.in_array(first_letter1))
                    document.getElementById('playlistid').options[n++] = new Option(final_array[m][0],final_array[m][1]);

            }
            if(rad_val_alphabet=='GL')
            {
                first_letter = final_array[m][0];
                first_letter1 = first_letter.charAt(0);
                if(v_array2.in_array(first_letter1))
                    document.getElementById('playlistid').options[n++] = new Option(final_array[m][0],final_array[m][1]);

            }
            if(rad_val_alphabet=='MR')
            {
                first_letter = final_array[m][0];
                first_letter1 = first_letter.charAt(0);
                if(v_array3.in_array(first_letter1))
                    document.getElementById('playlistid').options[n++] = new Option(final_array[m][0],final_array[m][1]);

            }

            if(rad_val_alphabet=='SV')
            {
                first_letter=final_array[m][0];
                first_letter1=first_letter.charAt(0);
                if(v_array4.in_array(first_letter1))
                    document.getElementById('playlistid').options[n++] = new Option(final_array[m][0],final_array[m][1]);

            }
            if(rad_val_alphabet=='WZ')
            {
                first_letter=final_array[m][0];
                first_letter1=first_letter.charAt(0);
                if(v_array5.in_array(first_letter1))
                    document.getElementById('playlistid').options[n++] = new Option(final_array[m][0],final_array[m][1]);

            }
        }
    }
    Array.prototype.in_array = function(p_val) {
        for(var i = 0, l = this.length; i < l; i++) {
            if(this[i] == p_val) {
                return true;
            }
        }
        return false;
    }