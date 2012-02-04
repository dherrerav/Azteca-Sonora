 function changepage(pageno)
    {
        document.getElementById("page").value=pageno;
        document.pagination.submit();
    }

    function my_message(vid)
    {
        var flg=confirm('Do you Really Want To Delete This Video? \n\nClick OK to continue. Otherwise click Cancel.\n');
        if (flg)
        {
            var r=document.getElementById('deletevideo').value=vid;
            document.deletemyvideo.submit();
            return true;
        }
        else
        {
            return false;
        }
    }
    function videoplay(vid,cat)
    {
        window.open('index.php?option=com_contushdvideoshare&view=player&id='+vid+'&catid='+cat,'_self');
    }
    function editvideo(evid)
    {

        window.open(evid,'_self');
    }
    function sortvalue(sortvalue)
    {
        document.getElementById("sorting").value=sortvalue;
        document.sortform.submit();
    }
    function membervalue(memid)
    {
        document.getElementById('memberidvalue').value=memid;
        document.memberidform.submit();
    }