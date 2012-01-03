/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        membervalidator.js
 * @location    /components/com_contushdvideosahre/js/membervalidator.js
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   validating new user registration and user login page
 */



function profilevalidate()
{
    if(document.getElementById("username").value=="")
    {
        alert("Please Enter Your User Name");
        document.getElementById("username").focus();
        return false;
    }
    if(document.getElementById("email").value=="")
    {
        alert("Please Enter Your Email");
        document.getElementById("email").focus();
        return false;
    }
    if(document.getElementById("email").value!="")
    {
        if(checkemail(document.getElementById("email").value)==false)
        {
            document.getElementById("email").value="";
            document.getElementById("email").focus();
            return false
        }
    }
    if(document.getElementById("firstname").value=="")
    {
        alert("Please Enter Your First Name");
        document.getElementById("firstname").focus();
        return false;
    }

    if(document.getElementById("lastname").value=="")
    {
        alert("Please Enter Your Last Name");
        document.getElementById("lastname").focus();
        return false;
    }
    if(document.getElementById("password").value=="")
    {
        alert("Please Enter Your Password");
        document.getElementById("password").focus();
        return false;
    }
    if(document.getElementById("password").value!="")
    {
        if(document.getElementById("password").value.length<6)
        {
            alert("Please Provide Minimum Of 6 Chars For Password");
            document.getElementById("password").focus();
            return false;
        }
    }
    if(document.getElementById("confirmpwd").value=="")
    {
        alert("Please Enter your Confirm Password");
        document.getElementById("confirmpwd").focus();
        return false;
    }
    if(document.getElementById("confirmpwd").value!="")
    {
        if(document.getElementById("confirmpwd").value.length<6)
        {
            alert("Please Enter Minimum Of 6 Chars For Confirm Password");
            document.getElementById("confirmpwd").focus();
            return false;
        }
    }



    if((document.getElementById("password").value!="") && (document.getElementById("confirmpwd").value!=""))
    {
        if(document.getElementById("password").value != document.getElementById("confirmpwd").value)
        {

            alert("Passwords do not match");
            document.getElementById("confirmpwd").focus();
            document.getElementById("confirmpwd").value="";
            document.getElementById("password").focus();
            document.getElementById("password").value="";
            return false;
        }
    }
    if(document.getElementById("txtcaptcha").value=="")
    {
        alert("Please Enter The Security Code");
        document.getElementById("txtcaptcha").focus();
        return false;
    }
    return true;
}
function checkemail(str)
{
    var filter=/^.+@.+\..{2,3}$/

    if (filter.test(str))
        testresults=true
    else {
        alert("Please Enter Valid Email Address!")
        testresults=false
    }
    return (testresults)
}

function memberlogin()
{
    if(document.getElementById("username1").value=="")
    {
        alert("Please Enter Your User Name");
        document.getElementById("username1").focus();
        return false;
    }
    if(document.getElementById("password1").value=="")
    {
        alert("Please Enter Your Password");
        document.getElementById("password1").focus();
        return false;
    }
    if(document.getElementById("password1").value!="")
    {
        if(document.getElementById("password1").value.length<6)
        {
            alert("Please Provide Minimum Of 6 Chars For Password");
            document.getElementById("password1").focus();
            return false;
        }
    }
    return true;
}

function checklogin(str)
{
    var filter=/^.+@.+\..{2,3}$/

    if (filter.test(str))
        testresults=true
    else {
        alert("Please Enter Valid Username!")
      
        testresults=false
    }
    return (testresults)
}

function videoupload()
{

    if(document.getElementById("filetype2").checked==true)
    {
        if(document.getElementById("Youtubeurl").value=="" || document.getElementById("Youtubeurl").value==" ")
        {
            alert("Please Enter valid Video URL");
            document.getElementById("Youtubeurl").focus();
            return false;
        }
    }

    if(document.getElementById("ffmpeg").value=="" && document.getElementById("seltype").value==2)
    {
        alert("Please Select Upload Video");
        document.getElementById("ffmpeg").focus();
        return false;
    }


    if(document.getElementById("normalvideoformval").value=="" && document.getElementById("seltype").value==1)
    {
        alert("Please Select Upload Video");
        document.getElementById("normalvideoformval").focus();
        return false;
    }

    if(document.getElementById("thumbimageformval").value=="" && document.getElementById("seltype").value==1)
    {
        alert("Please Select Thumb Image");
        document.getElementById("thumbimageformval").focus();
        return false;
    }
    if(document.getElementById("title").value=="")
    {
        alert("Please Enter Your Video Title");
        document.getElementById("title").focus();
        return false;
    }
 
    if(document.getElementById("tagname").value=="")
    {
        alert("Please Enter Video Category");
        document.getElementById("tagname").focus();
        return false;
    }
    return true;
}

function videoupload1()
{

    if(document.getElementById("url").value=="")
    {
        alert("Please Enter Youtube Url");
        document.getElementById("url").focus();
        return false;
    }
    if(document.getElementById("url").value!="")
    {
        if(validate_youtube_url(document.getElementById("url").value)==false)
        {
            document.getElementById("url").value="";
            document.getElementById("url").focus();
            return false;
        }

    }
    
    return true;
}

function validate_youtube_url(str,protocol)
{
    if(!protocol && protocol != ''){
        protocol = '(http://)|(http://www.)|(www.)';
    }
    protocol = protocol.replace(/\//g, '\/', protocol).replace(/\./g, '\.');
    protocol = (protocol != '') ? '^(' + protocol + ')' : protocol;
    match_exp1 = new RegExp(protocol + 'youtube\.com\/(.+)(v=.+)', 'gi');
    match_exp2 = new RegExp(protocol + '(.*?)blip\.tv\/file\/[0-9]+/');
    match_exp3 = new RegExp(protocol + 'metacafe\.com\/watch\/(.*?)\/(.*?)\//');
    match_exp4 = new RegExp(protocol + 'google\.com\/videoplay\?docid=[^&]+/');
    var matches1 = match_exp1.exec(str);
    var matches2 = match_exp2.exec(str);
    var matches3 = match_exp3.exec(str);
    var matches4 = match_exp4.exec(str);
    var matches5 = match_exp5.exec(str);
    if(matches1==null){
        alert("Invalid Youtube Url");
        testvalue=false;
    }else{
        if(matches1!=null)
        {
            matchesf=matches1;
        }
        else if(matches2!=null)
        {
            matchesf=matches2;
        }
        else if(matches3!=null)
        {
            matchesf=matches3;
        }
        else if(matches4!=null)
        {
            matchesf=matches4;
        }
        else if(matches5!=null)
        {
            matchesf=matches5;
        }
        testvalue=true;
    }
    return (testvalue);
}