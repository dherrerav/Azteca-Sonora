(function(){
    function aa(a){
        throw a;
    }var g=true,h=null,j=false,ba=unescape,ca=encodeURIComponent,l=window,da=Object,ea=screen,fa=navigator,ha=undefined,ia=parseInt,ja=parseFloat,ka=String,la=confirm,m=document,ma=decodeURIComponent,na=isNaN,n=Math;function oa(a,b){
        return a.hash=b
        }function pa(a,b){
        return a.relatedTarget=b
        }function qa(a,b){
        return a.width=b
        }function ra(a,b){
        return a.text=b
        }function o(a,b){
        return a.innerHTML=b
        }function p(a,b){
        return a.value=b
        }function sa(a,b){
        return a.preventDefault=b
        }
    function ta(a,b){
        return a.paddingTop=b
        }function ua(a,b){
        return a.currentTarget=b
        }function va(a,b){
        return a.left=b
        }function wa(a,b){
        return a.charCode=b
        }function xa(a,b){
        return a.remove=b
        }function ya(a,b){
        return a.keyCode=b
        }function za(a,b){
        return a.type=b
        }function Aa(a,b){
        return a.clear=b
        }function Ba(a,b){
        return a.name=b
        }function Ca(a,b){
        return a.cancelBubble=b
        }function Fa(a,b){
        return a.clientX=b
        }function Ga(a,b){
        return a.clientY=b
        }function Ha(a,b){
        return a.visibility=b
        }
    function Ia(a,b){
        return a.scrollTop=b
        }function Ja(a,b){
        return a.toString=b
        }function Ka(a,b){
        return a.length=b
        }function La(a,b){
        return a.title=b
        }function Ma(a,b){
        return a.position=b
        }function Na(a,b){
        return a.prototype=b
        }function q(a,b){
        return a.className=b
        }function Oa(a,b){
        return a.checked=b
        }function Pa(a,b){
        return a.stopPropagation=b
        }function Qa(a,b){
        return a.location=b
        }function Ra(a,b){
        return a.disabled=b
        }function Sa(a,b){
        return a.target=b
        }function Ta(a,b){
        return a.coords=b
        }
    function Ua(a,b){
        return a.returnValue=b
        }function Va(a,b){
        return a.href=b
        }function Wa(a,b){
        return a.backgroundImage=b
        }function Xa(a,b){
        return a.display=b
        }function Ya(a,b){
        return a.height=b
        }
    var r="appendChild",$a="forms",t="push",ab="hash",bb="getBoundingClientRect",cb="page",db="open",eb="test",fb="shift",gb="exec",hb="width",ib="round",jb="slice",u="replace",kb="nodeType",lb="floor",mb="responseText",nb="getElementById",ob="innerHTML",pb="offsetWidth",qb="dataset",rb="charAt",sb="blur",tb="createTextNode",ub="getData",v="value",vb="preventDefault",wb="item",xb="insertBefore",w="indexOf",yb="capture",zb="nodeName",Ab="left",Bb="write",Cb="insertRow",Db="screenX",Eb="screenY",Fb="match",
    Gb="getBoxObjectFor",Hb="innerHeight",Ib="opera",Kb="focus",Lb="createElement",Mb="scrollHeight",Nb="keyCode",Ob="firstChild",Pb="select",Qb="forEach",Rb="clientLeft",Sb="addEventListener",Tb="referrer",Ub="setAttribute",Vb="elements",Wb="clientTop",Xb="handleEvent",Yb="cloneNode",Zb="type",$b="clear",ac="attachEvent",bc="defaultView",cc="name",dc="nextSibling",ec="contentWindow",fc="getTime",gc="getElementsByTagName",hc="clientX",ic="clientY",jc="documentElement",kc="substr",lc="visibility",mc="setData",
    nc="scrollTop",oc="toString",x="length",pc="propertyIsEnumerable",qc="title",y="prototype",rc="selectedIndex",sc="className",tc="clientWidth",uc="checked",vc="setTimeout",wc="document",xc="removeEventListener",A="split",yc="offsetParent",zc="duration",Ac="stopPropagation",Bc="userAgent",Cc="stack",B="location",Dc="save",Ec="reload",Fc="hasOwnProperty",C="style",Gc="PixelRadius",Hc="close",Ic="body",Jc="selectionStart",Kc="removeChild",Lc="parent",Mc="target",D="call",Nc="pathname",Oc="options",Pc=
    "random",Qc="getAttribute",Rc="coords",Sc="responseXML",Tc="clientHeight",Uc="scrollLeft",Vc="compatMode",Wc="bottom",Xc="currentStyle",Zc="href",$c="substring",ad="console",bd="rows",cd="action",dd="apply",ed="tagName",fd="element",gd="startTime",E="parentNode",hd="fileName",id="display",jd="offsetTop",kd="height",ld="splice",md="offsetHeight",F="join",nd="unshift",od="nodeValue",pd="toLowerCase",qd="right",rd="event",H;var sd=this,I=function(a,b,c){
        a=a[A](".");c=c||sd;!(a[0]in c)&&c.execScript&&c.execScript("var "+a[0]);for(var d;a[x]&&(d=a[fb]());)if(!a[x]&&td(b))c[d]=b;else c=c[d]?c[d]:(c[d]={})
            },ud=function(a,b){
        for(var c=a[A]("."),d=b||sd,e;e=c[fb]();)if(d[e])d=d[e];else return h;return d
        },vd=function(){},wd=function(a){
        a.c=function(){
            return a.Ii||(a.Ii=new a)
            }
        },xd=function(a){
        var b=typeof a;if(b=="object")if(a){
            if(a instanceof Array||!(a instanceof da)&&da[y][oc][D](a)=="[object Array]"||typeof a[x]=="number"&&
                typeof a[ld]!="undefined"&&typeof a[pc]!="undefined"&&!a[pc]("splice"))return"array";if(!(a instanceof da)&&(da[y][oc][D](a)=="[object Function]"||typeof a[D]!="undefined"&&typeof a[pc]!="undefined"&&!a[pc]("call")))return"function"
                }else return"null";else if(b=="function"&&typeof a[D]=="undefined")return"object";return b
        },td=function(a){
        return a!==ha
        },yd=function(a){
        return xd(a)=="array"
        },zd=function(a){
        var b=xd(a);return b=="array"||b=="object"&&typeof a[x]=="number"
        },Ad=function(a){
        return typeof a==
        "string"
        },Bd=function(a){
        return xd(a)=="function"
        },Cd=function(a){
        a=xd(a);return a=="object"||a=="array"||a=="function"
        },Fd=function(a){
        if(a[Fc]&&a[Fc](Dd))return a[Dd];a[Dd]||(a[Dd]=++Ed);return a[Dd]
        },Dd="closure_uid_"+n[lb](n[Pc]()*2147483648)[oc](36),Ed=0,Gd=function(a){
        var b=xd(a);if(b=="object"||b=="array"){
            if(a.C)return a.C[D](a);b=b=="array"?[]:{};for(var c in a)b[c]=Gd(a[c]);return b
            }return a
        },J=function(a,b){
        var c=b||sd;if(arguments[x]>2){
            var d=Array[y][jb][D](arguments,2);return function(){
                var e=
                Array[y][jb][D](arguments);Array[y][nd][dd](e,d);return a[dd](c,e)
                }
            }else return function(){
            return a[dd](c,arguments)
            }
        },Id=function(a){
        var b=Array[y][jb][D](arguments,1);return function(){
            var c=Array[y][jb][D](arguments);c[nd][dd](c,b);return a[dd](this,c)
            }
        },Jd=Date.now||function(){
        return+new Date
        },Kd=function(a,b){
        function c(){}Na(c,b[y]);a.z=b[y];Na(a,new c)
        };Function[y].bind=function(a){
        if(arguments[x]>1){
            var b=Array[y][jb][D](arguments,1);b[nd](this,a);return J[dd](h,b)
            }else return J(this,a)
            };var Ld,Md,Rd=function(a,b,c,d,e,f,i,k,s,z){
        if(m[nb]){
            this.Gf=z?z:"detectflash";this.ok=Nd(this.Gf);this.Ta={};this.Df={};this.attributes=[];a&&this[Ub]("swf",a);b&&this[Ub]("id",b);c&&this[Ub]("width",c);d&&this[Ub]("height",d);e&&this[Ub]("version",new Od(e[oc]()[A](".")));this.Ob=Pd();if(!l[Ib]&&m.all&&this.Ob.B>7)if(!Ld){
                Md=function(){
                    __flash_unloadHandler=function(){};__flash_savedUnloadHandler=function(){};l[ac]("onunload",Qd)
                    };l[ac]("onbeforeunload",Md);Ld=g
                }f&&this.Ca("bgcolor",f);this.Ca("quality",
                i?i:"high");this[Ub]("useExpressInstall",j);this[Ub]("doExpressInstall",j);this[Ub]("xiRedirectUrl",k?k:l[B]);this[Ub]("redirectUrl","");s&&this[Ub]("redirectUrl",s)
            }
        };
    Na(Rd,{
        Cf:function(a){
            this.Ff=!a?"expressinstall.swf":a;this[Ub]("useExpressInstall",g)
            },
        setAttribute:function(a,b){
            this.attributes[a]=b
            },
        getAttribute:function(a){
            return this.attributes[a]||""
            },
        Ca:function(a,b){
            this.Ta[a]=b
            },
        I:function(a,b){
            this.Df[a]=b
            },
        Ae:function(){
            var a=[],b,c=this.Df;for(b in c)a[a[x]]=b+"="+c[b];return a
            },
        ki:function(){
            var a="";if(fa.plugins&&fa.mimeTypes&&fa.mimeTypes[x]){
                if(this[Qc]("doExpressInstall")){
                    this.I("MMplayerType","PlugIn");this[Ub]("swf",this.Ff)
                    }a='<embed type="application/x-shockwave-flash" src="'+
                this[Qc]("swf")+'" width="'+this[Qc]("width")+'" height="'+this[Qc]("height")+'" style="'+(this[Qc]("style")||"")+'"';a+=' id="'+this[Qc]("id")+'" name="'+this[Qc]("id")+'" ';var b=this.Ta;for(var c in b)a+=[c]+'="'+b[c]+'" ';b=this.Ae()[F]("&");if(b[x]>0)a+='flashvars="'+b+'"';a+="/>"
                }else{
                if(this[Qc]("doExpressInstall")){
                    this.I("MMplayerType","ActiveX");this[Ub]("swf",this.Ff)
                    }a='<object id="'+this[Qc]("id")+'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+this[Qc]("width")+'" height="'+
                this[Qc]("height")+'" style="'+(this[Qc]("style")||"")+'">';a+='<param name="movie" value="'+this[Qc]("swf")+'" />';b=this.Ta;for(c in b)a+='<param name="'+c+'" value="'+b[c]+'" />';b=this.Ae()[F]("&");if(b[x]>0)a+='<param name="flashvars" value="'+b+'" />';a+="</object>"
                }return a
            },
        write:function(a){
            if(this[Qc]("useExpressInstall"))if(this.Ob.xb(new Od([6,0,65]))&&!this.Ob.xb(this[Qc]("version"))){
                this[Ub]("doExpressInstall",g);this.I("MMredirectURL",escape(this[Qc]("xiRedirectUrl")));La(m,m[qc][jb](0,
                    47)+" - Flash Player Installation");this.I("MMdoctitle",m[qc])
                }if(this.ok||this[Qc]("doExpressInstall")||this.Ob.xb(this[Qc]("version"))){
                o(typeof a=="string"?m[nb](a):a,this.ki());return g
                }else this[Qc]("redirectUrl")!=""&&m[B][u](this[Qc]("redirectUrl"));return j
            }
        });
    var Pd=function(){
        var a=new Od([0,0,0]),b;if(fa.plugins&&fa.mimeTypes[x]){
            if((b=fa.plugins["Shockwave Flash"])&&b.description)a=new Od(b.description[u](/([a-zA-Z]|\s)+/,"")[u](/(\s+r|\s+b[0-9]+)/,".")[A]("."))
                }else if(fa[Bc]&&fa[Bc][w]("Windows CE")>=0){
            b=1;for(var c=3;b;)try{
                c++;b=new ActiveXObject("ShockwaveFlash.ShockwaveFlash."+c);a=new Od([c,0,0])
                }catch(d){
                b=h
                }
            }else{
            try{
                b=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7")
                }catch(e){
                try{
                    b=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");
                    a=new Od([6,0,21]);b.Jk="always"
                    }catch(f){
                    if(a.B==6)return a
                        }try{
                    b=new ActiveXObject("ShockwaveFlash.ShockwaveFlash")
                    }catch(i){}
                }if(b)a=new Od(b.GetVariable("$version")[A](" ")[1][A](","))
                }return a
        },Od=function(a){
        this.B=a[0]!=h?ia(a[0],10):0;this.W=a[1]!=h?ia(a[1],10):0;this.rev=a[2]!=h?ia(a[2],10):0
        };Od[y].xb=function(a){
        if(this.B<a.B)return j;if(this.B>a.B)return g;if(this.W<a.W)return j;if(this.W>a.W)return g;if(this.rev<a.rev)return j;return g
        };
    var Nd=function(a){
        var b=m[B].search||m[B][ab];if(a==h)return Sd(b);if(b){
            b=b[$c](1)[A]("&");for(var c=0;c<b[x];c++)if(b[c][$c](0,b[c][w]("="))==a)return Sd(b[c][$c](b[c][w]("=")+1))
                }return""
        },Sd=function(a){
        return/[\\\"<>;]/[gb](a)!=h&&typeof ca!="undefined"?ca(a):a},Qd=function(){for(var a=m[gc]("OBJECT"),b=a[x]-1;b>=0;b--){Xa(a[b][C],"none");for(var c in a[b])if(typeof a[b][c]=="function")a[b][c]=function(){}}};if(!m[nb]&&m.all)m.getElementById=function(a){return m.all[a]};var Td=Array[y],Ud=Td[w]?function(a,b,c){return Td[w][D](a,b,c)}:function(a,b,c){c=c==h?0:c<0?n.max(0,a[x]+c):c;if(Ad(a)){if(!Ad(b)||b[x]!=1)return-1;return a[w](b,c)}for(c=c;c<a[x];c++)if(c in a&&a[c]===b)return c;return-1},K=Td[Qb]?function(a,b,c){Td[Qb][D](a,b,c)}:function(a,b,c){for(var d=a[x],e=Ad(a)?a[A](""):a,f=0;f<d;f++)f in e&&b[D](c,e[f],f,a)},Vd=Td.filter?function(a,b,c){return Td.filter[D](a,b,c)}:function(a,b,c){for(var d=a[x],e=[],f=0,i=Ad(a)?a[A](""):a,k=0;k<d;k++)if(k in i){var s=
        i[k];if(b[D](c,s,k,a))e[f++]=s
            }return e
    },Wd=Td.map?function(a,b,c){
        return Td.map[D](a,b,c)
        }:function(a,b,c){
        for(var d=a[x],e=new Array(d),f=Ad(a)?a[A](""):a,i=0;i<d;i++)if(i in f)e[i]=b[D](c,f[i],i,a);return e
        },Xd=function(a,b,c){
        a:{
            for(var d=a[x],e=Ad(a)?a[A](""):a,f=0;f<d;f++)if(f in e&&b[D](c,e[f],f,a)){
                b=f;break a
            }b=-1
            }return b<0?h:Ad(a)?a[rb](b):a[b]
        },Yd=function(a,b){
        return Ud(a,b)>=0
        },Zd=function(a,b){
        var c=Ud(a,b),d;if(d=c>=0)Td[ld][D](a,c,1)[x]==1;return d
        },$d=function(){
        return Td.concat[dd](Td,
            arguments)
        },ae=function(a){
        if(yd(a))return $d(a);else{
            for(var b=[],c=0,d=a[x];c<d;c++)b[c]=a[c];return b
            }
        },be=function(a){
        for(var b=1;b<arguments[x];b++){
            var c=arguments[b],d;if(yd(c)||(d=zd(c))&&c[Fc]("callee"))a[t][dd](a,c);else if(d)for(var e=a[x],f=c[x],i=0;i<f;i++)a[e+i]=c[i];else a[t](c)
                }
        },de=function(a){
        return Td[ld][dd](a,ce(arguments,1))
        },ce=function(a,b,c){
        return arguments[x]<=2?Td[jb][D](a,b):Td[jb][D](a,b,c)
        };var ee;var fe=function(a){
        return(a=a[sc])&&typeof a[A]=="function"?a[A](/\s+/):[]
        },L=function(a){
        var b=fe(a),c;c=ce(arguments,1);for(var d=0,e=0;e<c[x];e++)if(!Yd(b,c[e])){
            b[t](c[e]);d++
        }c=d==c[x];q(a,b[F](" "));return c
        },M=function(a){
        var b=fe(a),c;c=ce(arguments,1);for(var d=0,e=0;e<b[x];e++)if(Yd(c,b[e])){
            de(b,e--,1);d++
        }c=d==c[x];q(a,b[F](" "));return c
        },N=function(a,b){
        return Yd(fe(a),b)
        },ge=function(a,b,c){
        c?L(a,b):M(a,b)
        },he=function(a,b){
        var c=!N(a,b);ge(a,b,c);return c
        };var ie=function(a,b){
        this.x=td(a)?a:0;this.y=td(b)?b:0
        };ie[y].C=function(){
        return new ie(this.x,this.y)
        };Ja(ie[y],function(){
        return"("+this.x+", "+this.y+")"
        });var je=function(a,b){
        return new ie(a.x-b.x,a.y-b.y)
        };var ke=function(a,b){
        qa(this,a);Ya(this,b)
        };ke[y].C=function(){
        return new ke(this[hb],this[kd])
        };Ja(ke[y],function(){
        return"("+this[hb]+" x "+this[kd]+")"
        });ke[y].floor=function(){
        qa(this,n[lb](this[hb]));Ya(this,n[lb](this[kd]));return this
        };ke[y].round=function(){
        qa(this,n[ib](this[hb]));Ya(this,n[ib](this[kd]));return this
        };var le=function(a,b,c){
        for(var d in a)b[D](c,a[d],d,a)
            },me=function(a){
        var b=[],c=0;for(var d in a)b[c++]=a[d];return b
        },ne=function(a){
        var b=[],c=0;for(var d in a)b[c++]=d;return b
        },oe=function(a,b,c){
        for(var d in a)if(b[D](c,a[d],d,a))return d
            },pe=function(a){
        for(var b in a)return j;return g
        },qe=function(a,b,c){
        if(b in a)return a[b];return c
        },re=function(a){
        var b={};for(var c in a)b[c]=a[c];return b
        },se=["constructor","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","toLocaleString","toString",
    "valueOf"],te=function(a){
        for(var b,c,d=1;d<arguments[x];d++){
            c=arguments[d];for(b in c)a[b]=c[b];for(var e=0;e<se[x];e++){
                b=se[e];if(da[y][Fc][D](c,b))a[b]=c[b]
                    }
            }
        };var ue=function(a){
        for(var b=1;b<arguments[x];b++){
            var c=ka(arguments[b])[u](/\$/g,"$$$$");a=a[u](/\%s/,c)
            }return a
        },ve=function(a){
        return a[u](/^[\s\xa0]+|[\s\xa0]+$/g,"")
        },we=/^[a-zA-Z0-9\-_.!~*'()]*$/,xe=function(a){
        a=ka(a);if(!we[eb](a))return ca(a);return a
        },ye=function(a){
        return ma(a[u](/\+/g," "))
        },Ee=function(a,b){
        if(b)return a[u](ze,"&amp;")[u](Ae,"&lt;")[u](Be,"&gt;")[u](Ce,"&quot;");else{
            if(!De[eb](a))return a;if(a[w]("&")!=-1)a=a[u](ze,"&amp;");if(a[w]("<")!=-1)a=a[u](Ae,"&lt;");if(a[w](">")!=
                -1)a=a[u](Be,"&gt;");if(a[w]('"')!=-1)a=a[u](Ce,"&quot;");return a
            }
        },ze=/&/g,Ae=/</g,Be=/>/g,Ce=/\"/g,De=/[&<>\"]/,Ge=function(a){
        if(a[w]("&")!=-1){
            if("document"in sd&&a[w]("<")==-1){
                a=a;var b=sd[wc][Lb]("a");o(b,a);b.normalize&&b.normalize();a=b[Ob][od];o(b,"");a=a
                }else a=Fe(a);return a
            }return a
        },Fe=function(a){
        return a[u](/&([^;]+);/g,function(b,c){
            switch(c){
                case "amp":return"&";case "lt":return"<";case "gt":return">";case "quot":return'"';default:if(c[rb](0)=="#"){
                    var d=Number("0"+c[kc](1));if(!na(d))return ka.fromCharCode(d)
                        }return b
                }
            })
        },
    Ie=function(a,b){
        for(var c=0,d=ve(ka(a))[A]("."),e=ve(ka(b))[A]("."),f=n.max(d[x],e[x]),i=0;c==0&&i<f;i++){
            var k=d[i]||"",s=e[i]||"",z=new RegExp("(\\d*)(\\D*)","g"),O=new RegExp("(\\d*)(\\D*)","g");do{
                var G=z[gb](k)||["","",""],Q=O[gb](s)||["","",""];if(G[0][x]==0&&Q[0][x]==0)break;c=He(G[1][x]==0?0:ia(G[1],10),Q[1][x]==0?0:ia(Q[1],10))||He(G[2][x]==0,Q[2][x]==0)||He(G[2],Q[2])
                }while(c==0)
        }return c
        },He=function(a,b){
        if(a<b)return-1;else if(a>b)return 1;return 0
        };var Je,Ke,Le,Me,Ne,Oe,Pe=function(){
        return sd.navigator?sd.navigator[Bc]:h
        },Qe=function(){
        return sd.navigator
        };Ne=Me=Le=Ke=Je=j;var Re;if(Re=Pe()){
        var Se=Qe();Je=Re[w]("Opera")==0;Ke=!Je&&Re[w]("MSIE")!=-1;Me=(Le=!Je&&Re[w]("WebKit")!=-1)&&Re[w]("Mobile")!=-1;Ne=!Je&&!Le&&Se.product=="Gecko"
        }var Te=Je,Ue=Ke,Ve=Ne,We=Le,Xe=Me,Ye=Qe();Oe=(Ye&&Ye.platform||"")[w]("Mac")!=-1;var Ze=!!Qe()&&(Qe().appVersion||"")[w]("X11")!=-1,$e="",af;
    if(Te&&sd[Ib]){
        var bf=sd[Ib].version;$e=typeof bf=="function"?bf():bf
        }else{
        if(Ve)af=/rv\:([^\);]+)(\)|;)/;else if(Ue)af=/MSIE\s+([^\);]+)(\)|;)/;else if(We)af=/WebKit\/(\S+)/;if(af){
            var cf=af[gb](Pe());$e=cf?cf[1]:""
            }
        }var df=$e,ef={},ff=function(a){
        return ef[a]||(ef[a]=Ie(df,a)>=0)
        };var jf=function(a){
        return a?new gf(hf(a)):ee||(ee=new gf)
        },P=function(a){
        return Ad(a)?m[nb](a):a
        },R=function(a,b,c){
        return kf(m,a,b,c)
        },kf=function(a,b,c,d){
        d=d||a;b=b&&b!="*"?b.toUpperCase():"";if(d.querySelectorAll&&(b||c)&&(!We||lf(a)||ff("528")))return d.querySelectorAll(b+(c?"."+c:""));if(c&&d.getElementsByClassName){
            a=d.getElementsByClassName(c);if(b){
                d={};for(var e=0,f=0,i;i=a[f];f++)if(b==i[zb])d[e++]=i;Ka(d,e);return d
                }else return a
                }a=d[gc](b||"*");if(c){
            d={};for(f=e=0;i=a[f];f++){
                b=i[sc];
                if(typeof b[A]=="function"&&Yd(b[A](/\s+/),c))d[e++]=i
                    }Ka(d,e);return d
            }else return a
            },nf=function(a,b){
        le(b,function(c,d){
            if(d=="style")a[C].cssText=c;else if(d=="class")q(a,c);else if(d=="for")a.htmlFor=c;else if(d in mf)a[Ub](mf[d],c);else a[d]=c
                })
        },mf={
        cellpadding:"cellPadding",
        cellspacing:"cellSpacing",
        colspan:"colSpan",
        rowspan:"rowSpan",
        valign:"vAlign",
        height:"height",
        width:"width",
        usemap:"useMap",
        frameborder:"frameBorder",
        type:"type"
    },of=function(a){
        var b=a[wc];if(We&&!ff("500")&&!Xe){
            if(typeof a[Hb]==
                "undefined")a=l;b=a[Hb];var c=a[wc][jc][Mb];if(a==a.top)if(c<b)b-=15;return new ke(a.innerWidth,b)
            }a=lf(b)&&(!Te||Te&&ff("9.50"))?b[jc]:b[Ic];return new ke(a[tc],a[Tc])
        },pf=function(a){
        var b=a[wc],c=0;if(b){
            a=of(a)[kd];c=b[Ic];var d=b[jc];if(lf(b)&&d[Mb])c=d[Mb]!=a?d[Mb]:d[md];else{
                b=d[Mb];var e=d[md];if(d[Tc]!=e){
                    b=c[Mb];e=c[md]
                    }c=b>a?b>e?b:e:b<e?b:e
                }
            }return c
        },qf=function(a){
        a=!We&&lf(a)?a[jc]:a[Ic];return new ie(a[Uc],a[nc])
        },sf=function(){
        return rf(m,arguments)
        },rf=function(a,b){
        var c=b[0],d=
        b[1];if(Ue&&d&&(d[cc]||d[Zb])){
            c=["<",c];d[cc]&&c[t](' name="',Ee(d[cc]),'"');if(d[Zb]){
                c[t](' type="',Ee(d[Zb]),'"');d=Gd(d);delete d[Zb]
            }c[t](">");c=c[F]("")
            }var e=a[Lb](c);if(d)if(Ad(d))q(e,d);else nf(e,d);if(b[x]>2){
            d=function(i){
                if(i)e[r](Ad(i)?a[tb](i):i)
                    };for(c=2;c<b[x];c++){
                var f=b[c];zd(f)&&!(Cd(f)&&f[kb]>0)?K(tf(f)?ae(f):f,d):d(f)
                }
            }return e
        },uf=function(a){
        return m[Lb](a)
        },lf=function(a){
        return a[Vc]=="CSS1Compat"
        },vf=function(a){
        for(var b;b=a[Ob];)a[Kc](b)
            },wf=function(a){
        return a&&a[E]?
        a[E][Kc](a):h
        },yf=function(a){
        return xf(a[Ob],g)
        },xf=function(a,b){
        for(;a&&a[kb]!=1;)a=b?a[dc]:a.previousSibling;return a
        },hf=function(a){
        return a[kb]==9?a:a.ownerDocument||a[wc]
        },zf=function(a,b){
        if("textContent"in a)a.textContent=b;else if(a[Ob]&&a[Ob][kb]==3){
            for(;a.lastChild!=a[Ob];)a[Kc](a.lastChild);a[Ob].data=b
            }else{
            vf(a);a[r](hf(a)[tb](b))
            }
        },Af={
        SCRIPT:1,
        STYLE:1,
        HEAD:1,
        IFRAME:1,
        OBJECT:1
    },Bf={
        IMG:" ",
        BR:"\n"
    },Cf=function(a,b,c){
        if(!(a[zb]in Af))if(a[kb]==3)c?b[t](ka(a[od])[u](/(\r\n|\r|\n)/g,
            "")):b[t](a[od]);else if(a[zb]in Bf)b[t](Bf[a[zb]]);else for(a=a[Ob];a;){
            Cf(a,b,c);a=a[dc]
            }
        },tf=function(a){
        if(a&&typeof a[x]=="number")if(Cd(a))return typeof a[wb]=="function"||typeof a[wb]=="string";else if(Bd(a))return typeof a[wb]=="function";return j
        },Ef=function(a,b,c){
        var d=b?b.toUpperCase():h;return Df(a,function(e){
            return(!d||e[zb]==d)&&(!c||N(e,c))
            },g)
        },Df=function(a,b,c,d){
        if(!c)a=a[E];c=d==h;for(var e=0;a&&(c||e<=d);){
            if(b(a))return a;a=a[E];e++
        }return h
        },gf=function(a){
        this.o=a||sd[wc]||
        m
        };H=gf[y];H.aa=jf;H.la=function(a){
        return Ad(a)?this.o[nb](a):a
        };H.a=gf[y].la;H.bi=function(a,b,c){
        return kf(this.o,a,b,c)
        };H.da=gf[y].bi;H.ri=function(a){
        return of(a||this.Oc()||l)
        };H.Fb=function(){
        return rf(this.o,arguments)
        };H.createElement=function(a){
        return this.o[Lb](a)
        };H.createTextNode=function(a){
        return this.o[tb](a)
        };H.Pb=function(){
        return lf(this.o)
        };H.Oc=function(){
        return this.o.parentWindow||this.o[bc]
        };H.ai=function(){
        return!We&&lf(this.o)?this.o[jc]:this.o[Ic]
        };H.Lb=function(){
        return qf(this.o)
        };
    H.appendChild=function(a,b){
        a[r](b)
        };var Ff="StopIteration"in sd?sd.StopIteration:Error("StopIteration"),Gf=function(){};Gf[y].next=function(){
        aa(Ff)
        };Gf[y].Tg=function(){
        return this
        };var Hf=function(a){
        if(typeof a.za=="function")return a.za();if(Ad(a))return a[A]("");if(zd(a)){
            for(var b=[],c=a[x],d=0;d<c;d++)b[t](a[d]);return b
            }return me(a)
        },If=function(a,b,c){
        if(typeof a[Qb]=="function")a[Qb](b,c);else if(zd(a)||Ad(a))K(a,b,c);else{
            var d;if(typeof a.Ja=="function")d=a.Ja();else if(typeof a.za!="function")if(zd(a)||Ad(a)){
                d=[];for(var e=a[x],f=0;f<e;f++)d[t](f);d=d
                }else d=ne(a);else d=void 0;e=Hf(a);f=e[x];for(var i=0;i<f;i++)b[D](c,e[i],d&&d[i],a)
                }
        };var Jf=function(a){
        this.O={};this.f=[];var b=arguments[x];if(b>1){
            if(b%2)aa(Error("Uneven number of arguments"));for(var c=0;c<b;c+=2)this.l(arguments[c],arguments[c+1])
                }else a&&this.Zg(a)
            };H=Jf[y];H.h=0;H.yb=0;H.za=function(){
        this.Eb();for(var a=[],b=0;b<this.f[x];b++)a[t](this.O[this.f[b]]);return a
        };H.Ja=function(){
        this.Eb();return this.f.concat()
        };H.ga=function(a){
        return Kf(this.O,a)
        };Aa(H,function(){
        this.O={};Ka(this.f,0);this.yb=this.h=0
        });
    xa(H,function(a){
        if(Kf(this.O,a)){
            delete this.O[a];this.h--;this.yb++;this.f[x]>2*this.h&&this.Eb();return g
            }return j
        });H.Eb=function(){
        if(this.h!=this.f[x]){
            for(var a=0,b=0;a<this.f[x];){
                var c=this.f[a];if(Kf(this.O,c))this.f[b++]=c;a++
            }Ka(this.f,b)
            }if(this.h!=this.f[x]){
            var d={};for(b=a=0;a<this.f[x];){
                c=this.f[a];if(!Kf(d,c)){
                    this.f[b++]=c;d[c]=1
                    }a++
            }Ka(this.f,b)
            }
        };H.A=function(a,b){
        if(Kf(this.O,a))return this.O[a];return b
        };
    H.l=function(a,b){
        if(!Kf(this.O,a)){
            this.h++;this.f[t](a);this.yb++
        }this.O[a]=b
        };H.Zg=function(a){
        var b;if(a instanceof Jf){
            b=a.Ja();a=a.za()
            }else{
            b=ne(a);a=me(a)
            }for(var c=0;c<b[x];c++)this.l(b[c],a[c])
            };H.C=function(){
        return new Jf(this)
        };H.Tg=function(a){
        this.Eb();var b=0,c=this.f,d=this.O,e=this.yb,f=this,i=new Gf;i.next=function(){
            for(;;){
                if(e!=f.yb)aa(Error("The map has changed since the iterator was created"));if(b>=c[x])aa(Ff);var k=c[b++];return a?k:d[k]
                }
            };return i
        };
    var Kf=function(a,b){
        return da[y][Fc][D](a,b)
        };var Nf=function(a){
        for(var b=[],c=Lf,d=a[Vb],e,f=0;e=d[f];f++)if(!(e.disabled||e[ed][pd]()=="fieldset")){
            var i=e[cc];switch(e[Zb][pd]()){
                case "file":case "submit":case "reset":case "button":break;case "select-multiple":e=Mf(e);if(e!=h)for(var k,s=0;k=e[s];s++)c(b,i,k);break;default:k=Mf(e);k!=h&&c(b,i,k)
                    }
            }d=a[gc]("input");for(f=0;e=d[f];f++)if(e.form==a&&e[Zb][pd]()=="image"){
            i=e[cc];c(b,i,e[v]);c(b,i+".x","0");c(b,i+".y","0")
            }return b[F]("&")
        },Lf=function(a,b,c){
        a[t](ca(b)+"="+ca(c))
        },Mf=function(a){
        var b=
        a[Zb];if(!td(b))return h;switch(b[pd]()){
            case "checkbox":case "radio":return a[uc]?a[v]:h;case "select-one":b=a[rc];return b>=0?a[Oc][b][v]:h;case "select-multiple":b=[];for(var c,d=0;c=a[Oc][d];d++)c.selected&&b[t](c[v]);return b[x]?b:h;default:return td(a[v])?a[v]:h
                }
        };var Of=/<[^>]*>|&[^;]+;/g,Pf=new RegExp("^[^A-Za-z\u00c0-\u00d6\u00d8-\u00f6\u00f8-\u02b8\u0300-\u0590\u0800-\u1fff\u2c00-\ufb1c\ufe00-\ufe6f\ufefd-\uffff]*[\u0591-\u07ff\ufb1d-\ufdff\ufe70-\ufefc]"),Qf=function(a,b){
        return Pf[eb](b?a[u](Of," "):a)
        };var Rf=l.yt&&l.yt.config_||{};I("yt.config_",Rf,void 0);var Sf=l.yt&&l.yt.globals_||{};I("yt.globals_",Sf,void 0);var Tf=l.yt&&l.yt.msgs_||{};I("yt.msgs_",Tf,void 0);var Uf=l.yt&&l.yt.timeouts_||[];I("yt.timeouts_",Uf,void 0);var Vf=l.yt&&l.yt.intervals_||[];I("yt.intervals_",Vf,void 0);
    var Xf=function(){
        Wf(Rf,arguments)
        },S=function(a,b){
        return a in Rf?Rf[a]:b
        },Yf=function(){
        for(var a=0,b=arguments[x];a<b;++a)Sf[arguments[a]]=1
            },Zf=function(a,b){
        var c=l[vc](a,b);Uf[t](c);return c
        },$f=function(a,b){
        var c=l.setInterval(a,b);Vf[t](c);return c
        },ag=function(a){
        l.clearTimeout(a)
        },bg=function(a){
        l.clearInterval(a)
        },T=function(a,b,c){
        b=b||{};if(a=a in Tf?Tf[a]:c)for(var d in b)a=a[u](new RegExp("\\$"+d,"gi"),b[d]);return a
        },Wf=function(a,b){
        if(b[x]>1){
            var c=b[0];a[c]=b[1]
            }else{
            var d=b[0];
            for(c in d)a[c]=d[c]
                }
        },cg=!!eval("/*@cc_on!@*/false");/*
 Portions of this code are from the MooTools project, received by
 YouTube under the MIT License. All other code is Copyright 2009 YouTube LLC.
 All Rights Reserved.

 Prototype JavaScript framework, version 1.4
 (c) 2005 Sam Stephenson <sam@conio.net>
 Prototype is freely distributable under the terms of an MIT-style license.
 For details, see the Prototype web site: http://prototype.conio.net/

 (c) 2006 Valerio Proietti (http://mad4milk.net). MIT-style license.

 Author: Robert Penner, <http://www.robertpenner.com/easing/>, modified to be used with mootools.
 License: Easing Equations v1.5, (c) 2003 Robert Penner, all rights reserved. Open Source BSD License.

*/
    var dg=function(){
        return function(){
            this.kb[dd](this,arguments)
            }
        },eg=function(a,b){
        for(var c in b)a[c]=b[c];return a
        },fg=function(a,b){
        return function(){
            return a[dd](b,arguments)
            }
        },gg=function(){};
    Na(gg,{
        mf:function(a){
            this.options=eg({
                onStart:function(){},
                onComplete:function(){},
                transition:function(b,c,d,e){
                    return d*(b/=e)*b+c
                    },
                transitionOut:function(b,c,d,e){
                    return-d*(b/=e)*(b-2)+c
                    },
                duration:333,
                unit:"px",
                wait:g,
                dontUseVisibility:j,
                fps:50
            },a||{})
            },
        rk:function(){
            var a=(new Date)[fc]();if(a<this.wf+this[Oc][zc]){
                this.$d=a-this.wf;this.$j()
                }else{
                Zf(fg(this[Oc].onComplete,this,this[fd]),10);this.yc();this.now=this.yf
                }this.Tc()
            },
        $j:function(){
            this.now=this.Bh(this.Xh,this.yf)
            },
        Bh:function(a,b){
            var c=
            b-a;return c<0?this[Oc].transition(this.$d,a,c,this[Oc][zc]):this[Oc].transitionOut(this.$d,a,c,this[Oc][zc])
            },
        yc:function(){
            bg(this.Jd);this.Jd=h;return this
            },
        Yg:function(a,b){
            this[Oc].wait||this.yc();if(!this.Jd){
                Zf(fg(this[Oc].onStart,this,this[fd]),10);this.Xh=a;this.yf=b;this.wf=(new Date)[fc]();this.Jd=$f(fg(this.rk,this),n[ib](1E3/this[Oc].fps));return this
                }
            },
        Gb:function(a,b){
            return this.Yg(a,b)
            },
        l:function(a){
            this.now=a;this.Tc();return this
            },
        show:function(){
            return this.l(1)
            },
        jb:function(){
            return this.l(0)
            },
        nf:function(a,b,c){
            if(b=="opacity"){
                if(!this[Oc].dontUseVisibility)if(c==0)Ha(a[C],"hidden");else if(a[C][lc]!="visible")Ha(a[C],"visible");if(l.ActiveXObject)a[C].filter="alpha(opacity="+c*100+")";a[C].opacity=c
                }else a[C][b]=c+this[Oc].unit
                }
        });var hg=dg();Na(hg,eg(new gg,{
        kb:function(a,b,c){
            this.element=P(a);this.mf(c);this.Fh=b
            },
        Tc:function(){
            this.nf(this[fd],this.Fh,this.now)
            }
        }));var ig=dg();
    Na(ig,eg(new gg,{
        kb:function(a,b){
            this.element=P(a);this.mf(b);this.now=1
            },
        yk:function(){
            return this.now>0?this.Gb(1,0):this.Gb(0,1)
            },
        jb:function(){
            return this.l(0)
            },
        Tc:function(){
            this.nf(this[fd],"opacity",this.now)
            }
        }));var jg={},kg=function(a,b,c,d){
        if(S("EVENTS_TRACKER_INSTALLED")){
            var e=jg[a];if(!e){
                var f=l._gaq._getAsyncTracker("eventsPageTracker");if(!f)return;l._gaq[t](function(){
                    e=f._createEventTracker(a);jg[a]=e
                    })
                }var i=c||ha,k=d||ha;l._gaq[t](function(){
                e._trackEvent(b,i,k)
                })
            }
        };var lg=function(a,b,c){
        a=R(a,b,c);return a[x]?a[0]:h
        };var mg=function(a,b,c){
        if(a[qb])a[qb][b]=c;else a[Ub]("data-"+b,c)
            },ng=function(a,b){
        return a[qb]?a[qb][b]:a[Qc]("data-"+b)
        };var og=function(a){
        if(a=a||ud("window.event")){
            za(this,a[Zb]);var b=a[Mc]||a.srcElement;if(b&&b[kb]==3)b=b[E];Sa(this,b);if(b=a.relatedTarget)try{
                b=b[zb]&&b
                }catch(c){
                b=h
                }else if(this[Zb]=="mouseover")b=a.fromElement;else if(this[Zb]=="mouseout")b=a.toElement;pa(this,b);Fa(this,a[hc]!==ha?a[hc]:a.pageX);Ga(this,a[ic]!==ha?a[ic]:a.pageY);ya(this,a[Nb]||0);wa(this,a.charCode||(this[Zb]=="keypress"?this[Nb]:0));this.D=a
            }
        };H=og[y];za(H,"");Sa(H,h);pa(H,h);ya(H,0);wa(H,0);H.D=h;Fa(H,0);Ga(H,0);
    sa(H,function(){
        Ua(this.D,j);this.D[vb]&&this.D[vb]()
        });Pa(H,function(){
        Ca(this.D,j);this.D[Ac]&&this.D[Ac]()
        });var pg={},qg=0,rg=function(a,b,c){
        return oe(pg,function(d){
            return d[0]==a&&d[1]==b&&d[2]==c
            })
        },U=function(a,b,c){
        if(!a||!(a[Sb]||a[ac]))return"";var d=rg(a,b,c);if(d)return d;d=++qg+"";var e=function(f){
            return c[D](a,new og(f))
            };pg[d]=[a,b,c,e];a[Sb]?a[Sb](b,e,j):a[ac]("on"+b,e);return d
        },tg=function(a,b,c){
        (a=rg(a,b,c))&&sg(a)
        },sg=function(a){
        if(a in pg){
            var b=pg[a],c=b[0],d=b[1];b=b[3];c[xc]?c[xc](d,b,j):c.detachEvent("on"+d,b);delete pg[a]
        }
        },ug=function(){
        for(var a in pg)sg(a)
            },vg=function(a){
        a=
        a||l[rd];a=a[Mc]||a.srcElement;if(a[kb]==3)a=a[E];return a
        },wg=function(a){
        a=a||l[rd];var b=a.relatedTarget;if(!b)if(a[Zb]=="mouseover")b=a.fromElement;else if(a[Zb]=="mouseout")b=a.toElement;return b
        },xg=function(a){
        a=a||l[rd];Ca(a,g);a[Ac]&&a[Ac]()
        },yg=function(a){
        a=a||l[rd];Ua(a,j);a[vb]&&a[vb]();return j
        };var Cg=function(a){
        this.vc={};this.wc={};this.Ta={};a=a||{};this.url=a.url||this.url;this.nc=a.url_v8||this.nc;this.oc=a.url_v9as2||this.oc;this.ed=a.min_version||this.ed;this.vc=a.args||re(zg);this.wc=a.attrs||re(Ag);this.Ta=a.params||re(Bg)
        },zg={
        enablejsapi:1
    },Ag={
        width:"640",
        height:"385"
    },Bg={
        allowscriptaccess:"always",
        allowfullscreen:"true",
        bgcolor:"#000000"
    };Cg[y].url="";Cg[y].nc="";Cg[y].oc="";Cg[y].ed="8.0.0";var Dg=function(){
        this.pc=[];this.Le()
        };wd(Dg);H=Dg[y];H.B=0;H.W=0;H.rev=0;H.nd="";H.Vh="";H.w=0;H.load=function(a){
        this.w>=3?a(this):this.pc[t](a)
        };H.pf=function(a){
        this.B=a[0];this.W=a[1];this.rev=a[2]
        };H.isSupported=function(a,b,c){
        a=typeof a=="string"?a[A]("."):[a,b,c];a[0]=ia(a[0],10)||0;a[1]=ia(a[1],10)||0;a[2]=ia(a[2],10)||0;return this.B>a[0]||this.B==a[0]&&this.W>a[1]||this.B==a[0]&&this.W==a[1]&&this.rev>=a[2]
        };H.sk=function(){
        return cg&&this.isSupported(6,0,65)
        };
    H.qh=function(){
        if(this.nd[w]("Gnash")>-1&&this.nd[w]("AVM2")==-1)return j;if(this.B==9&&this.W==1)return j;if(this.B==9&&this.W==0&&this.rev==1)return j;return this.B>=9
        };H.rh=function(){
        if(fa[Bc][w]("Sony/COM2")>-1&&!this.isSupported(9,1,58))return j;return g
        };H.Le=function(){
        if(this.w<3)if(this.w<1)this.Uh();else this.w<2?this.Th():this.Ee()
            };H.Bf=function(a){
        this.w=a;this.B>0?this.Ee():this.Le()
        };
    H.vi=function(a){
        var b;if(b=a){
            var c=b[w]("Shockwave Flash");if(c>=0)b=b[kc](c+15);c=b[A](" ");var d="";b="";for(var e=0,f=c[x];e<f;e++)if(d)if(b)break;else b=c[e];else d=c[e];d=d[A](".");c=ia(d[0],10)||0;d=ia(d[1],10)||0;e=0;if(b[rb](0)=="r"||b[rb](0)=="d")e=ia(b[kc](1),10)||0;b=[c,d,e]
            }else b=[0,0,0];this.nd=a;this.pf(b);this.Bf(1)
        };H.De=function(a){
        var b;if(a){
            b=a[A](" ")[1][A](",");b=[ia(b[0],10)||0,ia(b[1],10)||0,ia(b[2],10)||0]
            }else b=[0,0,0];this.Vh=a;this.pf(b);this.Bf(2)
        };
    H.Ee=function(){
        if(this.w<3){
            this.w=3;for(var a=0,b=this.pc[x];a<b;a++)this.pc[a](this);this.pc=[]
            }
        };H.Uh=function(){
        var a=ud("window.navigator.plugins"),b=ud("window.navigator.mimeTypes");a=a&&a["Shockwave Flash"];b=b&&b["application/x-shockwave-flash"];this.vi(a&&b&&b.enabledPlugin&&a.description||"")
        };
    H.Th=function(){
        var a,b,c,d;if(cg){
            try{
                a=new ActiveXObject("ShockwaveFlash.ShockwaveFlash")
                }catch(e){
                a=h
                }a||this.De("")
            }else{
            c=m[gc]("body")[0];d=m[Lb]("object");d[Ub]("type","application/x-shockwave-flash");a=c[r](d)
            }var f=J(this.De,this),i=0,k=function(){
            if(a&&"GetVariable"in a)try{
                b=a.GetVariable("$version")
                }catch(s){
                b=""
                }if(b||i>=10){
                c&&d&&c[Kc](d);f(b||"")
                }else{
                i++;Zf(k,10)
                }
            };Zf(k,0)
        };var Eg=function(a){
        this.stack=(new Error)[Cc]||"";if(a)this.message=ka(a)
            };Kd(Eg,Error);Ba(Eg[y],"CustomError");var Fg=function(a,b){
        b[nd](a);Eg[D](this,ue[dd](h,b));b[fb]();this.Tk=a
        };Kd(Fg,Eg);Ba(Fg[y],"AssertionError");var Gg=function(a){
        aa(new Fg("Failure"+(a?": "+a:""),Array[y][jb][D](arguments,1)))
        };var Hg=new RegExp("^(?:([^:/?#.]+):)?(?://(?:([^/?#]*)@)?([\\w\\d\\-\\u0100-\\uffff.%]*)(?::([0-9]+))?)?([^?#]+)?(?:\\?([^#]*))?(?:#(.*))?$"),Ig=function(a,b){
        for(var c in b){
            var d=c,e=b[c];if(yd(e)){
                e=e;for(var f=0;f<e[x];f++){
                    a[t]("&",d);e[f]!==""&&a[t]("=",xe(e[f]))
                    }
                }else if(e!=h){
                a[t]("&",d);e!==""&&a[t]("=",xe(e))
                }
            }return a
        };var Jg=function(a){
        if(a[rb](0)=="?")a=a[kc](1);a=a[A]("&");for(var b={},c=0,d=a[x];c<d;c++){
            var e=a[c][A]("=");if(e[x]==2){
                var f=e[0];e=ye(e[1]);if(f in b)if(yd(b[f]))be(b[f],e);else b[f]=[b[f],e];else b[f]=e
                    }
            }return b
        },Kg=function(a){
        if(a[rb](0)=="#")a=a[rb](1)=="!"?a[kc](2):a[kc](1);return Jg(a)
        },Lg=function(a){
        a=Ig([],a);a[0]="";return a[F]("")
        },Mg=function(a,b){
        var c=Ig([a],b);if(c[1]){
            var d=c[0],e=d[w]("#");if(e>=0){
                c[t](d[kc](e));c[0]=d=d[kc](0,e)
                }e=d[w]("?");if(e<0)c[1]="?";else if(e==d[x]-
                1)c[1]=ha
                }return c[F]("")
        },Ng=function(a){
        a=a[A]("/",3);if(a[x]>=3&&a[0]=="http:"&&a[1]==""){
            var b=a[2][A](".").reverse();if(b[x]<2)return j;var c=b[0];b=b[1];if(b=="youtube"&&c=="com")return g;if(b=="google")return g;if(a[2]=="google"&&(b=="co"&&c=="uk"||b=="com"&&c=="au"))return g
                }return j
        };var Og=function(a,b,c){
        var d=Pd();if(d.B==9)if(fa[Bc][w]("Sony/COM2")>-1)d.xb(new Od([9,1,58]))||(d=new Od([8,0,0]));return d.xb(new Od([a,b,c]))
        },Pg=function(a,b,c){
        if((a=P(a))&&b&&c){
            c instanceof Cg||(c=new Cg(c));var d=re(c.wc),e=re(c.Ta);e.flashvars=Lg(c.vc);c=[];if(cg){
                d.classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000";e.movie=b;c[t]("<object ");for(var f in d)c[t](f,'="',d[f],'"');c[t](">");for(f in e)c[t]('<param name="',f,'" value="',e[f],'">');c[t]("</object>")
                }else{
                za(d,"application/x-shockwave-flash");
                d.src=b;c[t]("<embed ");for(f in d)c[t](f,'="',d[f],'"');for(f in e)c[t](f,'="',e[f],'"');c[t](" />")
                }o(a,c[F](""))
            }
        },Qg=function(a,b){
        if(a){
            a instanceof Cg||(a=new Cg(a));var c=!!b,d=P(a.wc.id),e=d?d[E]:h;if(!d||!e)Zf(function(){
                Qg(a)
                },50);else{
                if(l!=l.top){
                    var f=h;if(m[Tb]){
                        var i=m[Tb][$c](0,128);Ng(i)||(f=i)
                        }else f="unknown";if(f){
                        c=g;a.vc.framer=f
                        }
                    }Dg.c().load(function(k){
                    if(k.isSupported(a.ed)){
                        var s="";fa[Bc][w]("Sony/COM2")>-1||(s=d.src||d.movie);if(k.qh()){
                            if(s!=a.url||c)Pg(e,a.url,a)
                                }else if(k.rh()){
                            if(s!=
                                a.oc||c)Pg(e,a.oc,a)
                                }else if(s!=a.nc||c)Pg(e,a.nc,a)
                            }else if(k.sk()){
                        k=new Cg({
                            url:"http://s.ytimg.com/yt/swf/expressInstall-vfl70493.swf",
                            args:{
                                MMredirectURL:l[B],
                                MMplayerType:"ActiveX",
                                MMdoctitle:m[qc]
                                }
                            });Pg(e,k.url,k)
                        }else o(e,'<div id="flash-upgrade">'+T("FLASH_UPGRADE")+"</div>")
                        })
                }
            }
        };var Rg=/\s*;\s*/,Sg=function(a,b,c,d,e){
        if(/[;=]/[eb](a))aa(Error('Invalid cookie name "'+a+'"'));if(/;/[eb](b))aa(Error('Invalid cookie value "'+b+'"'));td(c)||(c=-1);m.cookie=a+"="+b+(e?";domain="+e:"")+(d?";path="+d:"")+(c<0?"":c==0?";expires="+(new Date(1970,1,1)).toUTCString():";expires="+(new Date((new Date)[fc]()+c*1E3)).toUTCString())
        },Tg=function(a,b){
        for(var c=a+"=",d=ka(m.cookie)[A](Rg),e=0,f;f=d[e];e++)if(f[w](c)==0)return f[kc](c[x]);return b
        };var Ug=function(a,b,c){
        a=""+a;Sg(a,b,c,"/","youtube.com")
        },Vg=function(a,b){
        a=""+a;return Tg(a,b)
        },Wg=function(a){
        a=""+a;var b=td(Tg(a));Sg(a,"",0,"/","youtube.com");return b
        };var Xg=function(a,b,c,d){
        this.top=a;this.right=b;this.bottom=c;va(this,d)
        };Xg[y].C=function(){
        return new Xg(this.top,this[qd],this[Wc],this[Ab])
        };Ja(Xg[y],function(){
        return"("+this.top+"t, "+this[qd]+"r, "+this[Wc]+"b, "+this[Ab]+"l)"
        });Xg[y].expand=function(a,b,c,d){
        if(Cd(a)){
            this.top-=a.top;this.right+=a[qd];this.bottom+=a[Wc];this.left-=a[Ab]
            }else{
            this.top-=a;this.right+=b;this.bottom+=c;this.left-=d
            }return this
        };var Yg=function(a,b,c,d){
        va(this,a);this.top=b;qa(this,c);Ya(this,d)
        };Yg[y].C=function(){
        return new Yg(this[Ab],this.top,this[hb],this[kd])
        };Ja(Yg[y],function(){
        return"("+this[Ab]+", "+this.top+" - "+this[hb]+"w x "+this[kd]+"h)"
        });Yg[y].Ji=function(a){
        var b=n.max(this[Ab],a[Ab]),c=n.min(this[Ab]+this[hb],a[Ab]+a[hb]);if(b<=c){
            var d=n.max(this.top,a.top);a=n.min(this.top+this[kd],a.top+a[kd]);if(d<=a){
                va(this,b);this.top=d;qa(this,c-b);Ya(this,a-d);return g
                }
            }return j
        };var $g=function(a,b,c){
        Ad(b)?Zg(a,c,b):le(b,Id(Zg,a))
        },Zg=function(a,b,c){
        a[C][ah(c)]=b
        },bh=function(a,b){
        var c=hf(a);if(c[bc]&&c[bc].getComputedStyle)if(c=c[bc].getComputedStyle(a,""))return c[b];return h
        },ch=function(a,b){
        return a[Xc]?a[Xc][b]:h
        },dh=function(a,b){
        return bh(a,b)||ch(a,b)||a[C][b]
        },eh=function(a){
        a=a?a[kb]==9?a:hf(a):m;if(Ue&&!jf(a).Pb())return a[Ic];return a[jc]
        },fh=function(a){
        var b=a[bb]();if(Ue){
            a=a.ownerDocument;b.left-=a[jc][Rb]+a[Ic][Rb];b.top-=a[jc][Wb]+a[Ic][Wb]
            }return b
        },
    gh=function(a){
        if(Ue)return a[yc];var b=hf(a),c=dh(a,"position"),d=c=="fixed"||c=="absolute";for(a=a[E];a&&a!=b;a=a[E]){
            c=dh(a,"position");d=d&&c=="static"&&a!=b[jc]&&a!=b[Ic];if(!d&&(a.scrollWidth>a[tc]||a[Mb]>a[Tc]||c=="fixed"||c=="absolute"))return a
                }return h
        },jh=function(a){
        var b=new Xg(0,Infinity,Infinity,0),c=jf(a),d=c.o[Ic],e=c.ai(),f;for(a=a;a=gh(a);)if((!Ue||a[tc]!=0)&&(!We||a[Tc]!=0||a!=d)&&(a.scrollWidth!=a[tc]||a[Mb]!=a[Tc])&&dh(a,"overflow")!="visible"){
            var i=hh(a),k;k=a;if(Ve&&!ff("1.9")){
                var s=
                ja(bh(k,"borderLeftWidth"));if(ih(k)){
                    var z=k[pb]-k[tc]-s-ja(bh(k,"borderRightWidth"));s+=z
                    }k=new ie(s,ja(bh(k,"borderTopWidth")))
                }else k=new ie(k[Rb],k[Wb]);i.x+=k.x;i.y+=k.y;b.top=n.max(b.top,i.y);b.right=n.min(b[qd],i.x+a[tc]);b.bottom=n.min(b[Wc],i.y+a[Tc]);va(b,n.max(b[Ab],i.x));f=f||a!=e
            }d=e[Uc];e=e[nc];if(We){
            b.left+=d;b.top+=e
            }else{
            va(b,n.max(b[Ab],d));b.top=n.max(b.top,e)
            }if(!f||We){
            b.right+=d;b.bottom+=e
            }c=c.ri();b.right=n.min(b[qd],d+c[hb]);b.bottom=n.min(b[Wc],e+c[kd]);return b.top>=0&&
        b[Ab]>=0&&b[Wc]>b.top&&b[qd]>b[Ab]?b:h
        },hh=function(a){
        var b,c=hf(a),d=dh(a,"position"),e=Ve&&c[Gb]&&!a[bb]&&d=="absolute"&&(b=c[Gb](a))&&(b[Db]<0||b[Eb]<0),f=new ie(0,0),i=eh(c);if(a==i)return f;if(a[bb]){
            b=fh(a);a=jf(c).Lb();f.x=b[Ab]+a.x;f.y=b.top+a.y
            }else if(c[Gb]&&!e){
            b=c[Gb](a);a=c[Gb](i);f.x=b[Db]-a[Db];f.y=b[Eb]-a[Eb]
            }else{
            b=a;do{
                f.x+=b.offsetLeft;f.y+=b[jd];if(b!=a){
                    f.x+=b[Rb]||0;f.y+=b[Wb]||0
                    }if(We&&dh(b,"position")=="fixed"){
                    f.x+=c[Ic][Uc];f.y+=c[Ic][nc];break
                }b=b[yc]
                }while(b&&b!=a);if(Te||
                We&&d=="absolute")f.y-=c[Ic][jd];for(b=a;(b=gh(b))&&b!=c[Ic]&&b!=i;){
                f.x-=b[Uc];if(!Te||b[ed]!="TR")f.y-=b[nc]
                    }
            }return f
        },kh=function(a,b,c){
        if(b instanceof ke){
            c=b[kd];b=b[hb]
            }else{
            if(c==ha)aa(Error("missing height argument"));c=c
            }qa(a[C],typeof b=="number"?n[ib](b)+"px":b);Ya(a[C],typeof c=="number"?n[ib](c)+"px":c)
        },lh=function(a){
        var b=Te&&!ff("10");if(dh(a,"display")!="none")return b?new ke(a[pb]||a[tc],a[md]||a[Tc]):new ke(a[pb],a[md]);var c=a[C],d=c[id],e=c[lc],f=c.position;Ha(c,"hidden");
        Ma(c,"absolute");Xa(c,"inline");if(b){
            b=a[pb]||a[tc];a=a[md]||a[Tc]
            }else{
            b=a[pb];a=a[md]
            }Xa(c,d);Ma(c,f);Ha(c,e);return new ke(b,a)
        },mh={},ah=function(a){
        return mh[a]||(mh[a]=ka(a)[u](/\-([a-z])/g,function(b,c){
            return c.toUpperCase()
            }))
        },ih=function(a){
        return"rtl"==dh(a,"direction")
        },qh=function(a){
        var b=hf(a),c=Ue&&a[Xc];if(c&&jf(b).Pb()&&c[hb]!="auto"&&c[kd]!="auto"&&!c.boxSizing){
            b=nh(a,c[hb],"width","pixelWidth");a=nh(a,c[kd],"height","pixelHeight");return new ke(b,a)
            }else{
            c=new ke(a[pb],a[md]);
            if(Ue){
                b=oh(a,"paddingLeft");var d=oh(a,"paddingRight"),e=oh(a,"paddingTop"),f=oh(a,"paddingBottom");b=new Xg(e,d,f,b)
                }else{
                b=bh(a,"paddingLeft");d=bh(a,"paddingRight");e=bh(a,"paddingTop");f=bh(a,"paddingBottom");b=new Xg(ja(e),ja(d),ja(f),ja(b))
                }if(Ue){
                d=ph(a,"borderLeft");e=ph(a,"borderRight");f=ph(a,"borderTop");a=ph(a,"borderBottom");a=new Xg(f,e,a,d)
                }else{
                d=bh(a,"borderLeftWidth");e=bh(a,"borderRightWidth");f=bh(a,"borderTopWidth");a=bh(a,"borderBottomWidth");a=new Xg(ja(f),ja(e),ja(a),ja(d))
                }return new ke(c[hb]-
                a[Ab]-b[Ab]-b[qd]-a[qd],c[kd]-a.top-b.top-b[Wc]-a[Wc])
            }
        },nh=function(a,b,c,d){
        if(/^\d+px?$/[eb](b))return ia(b,10);else{
            var e=a[C][c],f=a.runtimeStyle[c];a.runtimeStyle[c]=a[Xc][c];a[C][c]=b;b=a[C][d];a[C][c]=e;a.runtimeStyle[c]=f;return b
            }
        },oh=function(a,b){
        return nh(a,ch(a,b),"left","pixelLeft")
        },rh={
        thin:2,
        medium:4,
        thick:6
    },ph=function(a,b){
        if(ch(a,b+"Style")=="none")return 0;var c=ch(a,b+"Width");if(c in rh)return rh[c];return nh(a,c,"left","pixelLeft")
        };var sh=function(a,b){
        if((a=P(a))&&a[C]){
            Xa(a[C],b?"":"none");ge(a,"hid",!b)
            }
        },th=function(a){
        a=P(a);if(!a)return j;return!(a[C][id]=="none"||N(a,"hid"))
        },uh=function(a){
        if(a=P(a))if(th(a)){
            Xa(a[C],"none");L(a,"hid")
            }else{
            Xa(a[C],"");M(a,"hid")
            }
        },vh=function(a,b){
        if(a=P(a))Ha(a[C],b?"visible":"hidden")
            },wh=function(a){
        a=P(a);if(!a)return h;var b=0,c=0;if(a[yc]){
            do{
                b+=a.offsetLeft;c+=a[jd]
                }while(a=a[yc])
        }return new ie(b,c)
        },V=function(){
        K(arguments,function(a){
            sh(a,g)
            })
        },W=function(){
        K(arguments,function(a){
            sh(a,
                j)
            })
        },xh=function(){
        K(arguments,uh)
        };var zh=function(){
        return yh&&yh()
        },yh=h;(function(){
        if(typeof XMLHttpRequest!="undefined")yh=function(){
            return new XMLHttpRequest
            };else if(typeof ActiveXObject!="undefined")yh=function(){
            return new ActiveXObject("Microsoft.XMLHTTP")
            }
        })();var Ah=function(a,b,c,d,e){
        var f=new zh;if("open"in f){
            f.onreadystatechange=function(){
                (f&&"readyState"in f?f.readyState:0)==4&&b&&b(f)
                };c=c||"GET";d=d||"";f[db](c,a,g);c=="POST"&&f.setRequestHeader("Content-Type","application/x-www-form-urlencoded");if(e)for(var i in e)f.setRequestHeader(i,e[i]);f.send(d)
            }
        },Bh=function(a){
        l[ad]&&l[ad].warn&&l[ad].warn(a)
        },X=function(a,b){
        var c=b.onComplete||h,d=b.onException||h,e=b.onError||h,f=b.update||h,i=b.json||j;Ah(a,function(k){
            var s;a:switch(k&&"status"in
                k?k.status:-1){
            case 0:case 200:case 204:case 304:s=g;break a;default:s=j;break a
                }if(s){
                var z=k[Sc];s=z?Ch(z):h;z=!!(z&&s);var O,G;if(z){
                    O=Dh(s,"return_code");G=Dh(s,"html_content");if(O==0){
                        if(f&&G)o(P(f),G);var Q=Dh(s,"css_content"),ga=Dh(s,"js_content");if(Q){
                            var Da=m[Lb]("style");Da[Ub]("type","text/css");if(Da.styleSheet)Da.styleSheet.cssText=Q;else Da[r](m[tb](Q));m[gc]("head")[0][r](Da)
                            }if(ga){
                            Q=m[Lb]("script");ra(Q,ga);m[gc]("head")[0][r](Q)
                            }
                        }
                    }if(c)if(z){
                    z=Dh(s,"redirect_on_success");if(O&&
                        z)Qa(l,z);else{
                        (s=Dh(s,O==0?"success_message":"error_message"))&&alert(s);k=i?eval("("+G+")"):k;if(O==0)c(k);else if(d)d(k);else s||Bh("Non-zero ("+O+") return code from AJAX request: "+a)
                            }
                    }else k[mb]?c(k):Bh("No xmlResponse or xhr.responseText from AJAX request: "+a)
                    }else e&&e(k)
                },b.method||"POST",b.postBody||h,b.headers||h)
        },Ch=function(a){
        if(!a)return h;return(a=("responseXML"in a?a[Sc]:a)[gc]("root"))&&a[x]>0?a[0]:h
        },Dh=function(a,b){
        if(!a)return h;var c=a[gc](b);return c&&c[x]>0&&c[0][Ob]?c[0][Ob][od]:
        h
        },Eh={};I("yt.net.ajax.setToken",function(a,b){
        Eh[a]=b
        },void 0);var Fh=function(a){
        return qe(Eh,a)
        };var Hh=function(a,b){
        try{
            var c,d=ud("window.location.href");c=typeof a=="string"?{
                message:a,
                name:"Unknown error",
                lineNumber:"Not available",
                fileName:d,
                stack:"Not available"
            }:!a.lineNumber||!a[hd]||!a[Cc]?{
                message:a.message,
                name:a[cc],
                lineNumber:a.lineNumber||a.Qk||"Not available",
                fileName:a[hd]||a.filename||a.sourceURL||d,
                stack:a[Cc]||"Not available"
                }:a;return"Message: "+Ee(c.message)+'\nUrl: <a href="view-source:'+c[hd]+'" target="_new">'+c[hd]+"</a>\nLine: "+c.lineNumber+"\n\nBrowser stack:\n"+
            Ee(c[Cc]+"-> ")+"[end]\n\nJS stack traversal:\n"+Ee(Gh(b)+"-> ")
            }catch(e){
            return"Exception trying to expose exception! You win, we lose. "+e
            }
        },Gh=function(a){
        return Ih(a||arguments.callee.caller,[])
        },Ih=function(a,b){
        var c=[];if(Yd(b,a))c[t]("[...circular reference...]");else if(a&&b[x]<50){
            c[t](Jh(a)+"(");for(var d=a.arguments,e=0;e<d[x];e++){
                e>0&&c[t](", ");var f;f=d[e];switch(typeof f){
                    case "object":f=f?"object":"null";break;case "string":f=f;break;case "number":f=ka(f);break;case "boolean":f=
                        f?"true":"false";break;case "function":f=(f=Jh(f))?f:"[fn]";break;case "undefined":default:f=typeof f;break
                        }if(f[x]>40)f=f[kc](0,40)+"...";c[t](f)
                }b[t](a);c[t](")\n");try{
                c[t](Ih(a.caller,b))
                }catch(i){
                c[t]("[exception trying to get caller]\n")
                }
            }else a?c[t]("[...long stack...]"):c[t]("[end]");return c[F]("")
        },Jh=function(a){
        a=ka(a);if(!Kh[a]){
            var b=/function ([^\(]+)/[gb](a);Kh[a]=b?b[1]:"[Anonymous]"
            }return Kh[a]
        },Kh={};var Lh=function(a,b,c,d,e){
        this.reset(a,b,c,d,e)
        };Lh[y].Oj=0;Lh[y].Hc=h;Lh[y].Gc=h;var Mh=0;Lh[y].reset=function(a,b,c,d,e){
        this.Oj=typeof e=="number"?e:Mh++;this.xf=d||Jd();this.Qa=a;this.$i=b;this.Si=c;delete this.Hc;delete this.Gc
        };Lh[y].Uj=function(a){
        this.Hc=a
        };Lh[y].Vj=function(a){
        this.Gc=a
        };Lh[y].vd=function(a){
        this.Qa=a
        };var Nh=function(a){
        this.Ra=a
        };Nh[y].J=h;Nh[y].Qa=h;Nh[y].fa=h;Nh[y].Ma=h;var Oh=function(a,b){
        Ba(this,a);p(this,b)
        };Ja(Oh[y],function(){
        return this[cc]
        });var Ph=new Oh("SHOUT",1200),Qh=new Oh("SEVERE",1E3),Rh=new Oh("WARNING",900),Sh=new Oh("INFO",800),Th=new Oh("CONFIG",700);H=Nh[y];H.getName=function(){
        return this.Ra
        };H.dh=function(a){
        if(!this.Ma)this.Ma=[];this.Ma[t](a)
        };H.Dj=function(a){
        var b=this.Ma;return!!b&&Zd(b,a)
        };H.Zh=function(){
        if(!this.fa)this.fa={};return this.fa
        };
    H.vd=function(a){
        this.Qa=a
        };H.ue=function(){
        if(this.Qa)return this.Qa;if(this.J)return this.J.ue();Gg("Root logger has no level set.");return h
        };H.Li=function(a){
        return a[v]>=this.ue()[v]
        };H.log=function(a,b,c){
        this.Li(a)&&this.Mh(this.fi(a,b,c))
        };H.fi=function(a,b,c){
        var d=new Lh(a,ka(b),this.Ra);if(c){
            d.Uj(c);d.Vj(Hh(c,arguments.callee.caller))
            }return d
        };H.Mh=function(a){
        for(var b=this;b;){
            b.oh(a);b=b.J
            }
        };H.oh=function(a){
        if(this.Ma)for(var b=0,c;c=this.Ma[b];b++)c(a)
            };H.bk=function(a){
        this.J=a
        };
    H.ah=function(a,b){
        this.Zh()[a]=b
        };var Uh={},Vh=h,Wh=function(){
        if(!Vh){
            Vh=new Nh("");Uh[""]=Vh;Vh.vd(Th)
            }
        },Xh=function(a){
        Wh();var b;if(!(b=Uh[a])){
            b=new Nh(a);var c=a.lastIndexOf("."),d=a[kc](0,c);c=a[kc](c+1);d=Xh(d);d.ah(c,b);b.bk(d);b=Uh[a]=b
            }return b
        };var Yh=function(){
        this.cf=Jd()
        },Zh=new Yh;Yh[y].l=function(a){
        this.cf=a
        };Yh[y].reset=function(){
        this.l(Jd())
        };Yh[y].A=function(){
        return this.cf
        };var $h=function(a){
        this.zj=a||"";this.qk=Zh
        };$h[y].rf=g;$h[y].mk=g;$h[y].jk=g;$h[y].tf=j;var ai=function(a){
        if(a<10)return"0"+a;return ka(a)
        },bi=function(a,b){
        var c=(a.xf-b)/1E3,d=c.toFixed(3),e=0;if(c<1)e=2;else for(;c<100;){
            e++;c*=10
            }for(;e-- >0;)d=" "+d;return d
        },ci=function(a){
        $h[D](this,a)
        };Kd(ci,$h);
    ci[y].Wh=function(a){
        var b=[];b[t](this.zj," ");if(this.rf){
            var c=new Date(a.xf);b[t]("[",ai(c.getFullYear()-2E3)+ai(c.getMonth()+1)+ai(c.getDate())+" "+ai(c.getHours())+":"+ai(c.getMinutes())+":"+ai(c.getSeconds())+"."+ai(n[lb](c.getMilliseconds()/10)),"] ")
            }this.mk&&b[t]("[",bi(a,this.qk.A()),"s] ");this.jk&&b[t]("[",a.Si,"] ");b[t](a.$i,"\n");this.tf&&a.Hc&&b[t](a.Gc,"\n");return b[F]("")
        };var di=function(){
        this.bf=J(this.fh,this);this.Kc=new ci;this.Kc.rf=j;this.Me=this.Kc.tf=j;this.Ri=""
        };di[y].Qj=function(a){
        if(a!=this.Me){
            var b;Wh();b=Vh;if(a)b.dh(this.bf);else{
                b.Dj(this.bf);this.Rk=""
                }this.Me=a
            }
        };di[y].fh=function(a){
        var b=this.Kc.Wh(a);if(l[ad]&&l[ad].firebug)switch(a.Qa){
            case Ph:l[ad].info(b);break;case Qh:l[ad].error(b);break;case Rh:l[ad].warn(b);break;default:l[ad].debug(b);break
                }else if(l[ad])l[ad].log(b);else if(l[Ib])l[Ib].postError(b);else this.Ri+=b
            };var ei=h;ei||(ei=new di);l[B][Zc][w]("Debug=true")!=-1&&ei.Qj(g);Xh("yt.player.logger").vd(Sh);var fi=function(a){
        a=ka(a);if(/^\s*$/[eb](a)?j:/^[\],:{}\s\u2028\u2029]*$/[eb](a[u](/\\["\\\/bfnrtu]/g,"@")[u](/"[^"\\\n\r\u2028\u2029\x00-\x08\x10-\x1f\x80-\x9f]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]")[u](/(?:^|:|,)(?:[\s\u2028\u2029]*\[)+/g,"")))try{
            return eval("("+a+")")
            }catch(b){}aa(Error("Invalid JSON string: "+a))
        };var gi=function(a,b){
        var c;if(a instanceof gi){
            this.bb(b==h?a.V:b);this.Ad(a.ra);this.Bd(a.wb);this.rd(a.fb);this.yd(a.Ua);this.xd(a.pb);this.zd(a.K.C());this.td(a.hb)
            }else if(a&&(c=ka(a)[Fb](Hg))){
            this.bb(!!b);this.Ad(c[1]||"",g);this.Bd(c[2]||"",g);this.rd(c[3]||"",g);this.yd(c[4]);this.xd(c[5]||"",g);this.ck(c[6]||"",g);this.td(c[7]||"",g)
            }else{
            this.bb(!!b);this.K=new hi(h,this,this.V)
            }
        };H=gi[y];H.ra="";H.wb="";H.fb="";H.Ua=h;H.pb="";H.hb="";H.Mi=j;H.V=j;
    Ja(H,function(){
        if(this.N)return this.N;var a=[];this.ra&&a[t](ii(this.ra,ji),":");if(this.fb){
            a[t]("//");this.wb&&a[t](ii(this.wb,ji),"@");var b;b=this.fb;b=Ad(b)?ca(b):h;a[t](b);this.Ua!=h&&a[t](":",ka(this.Ua))
            }this.pb&&a[t](ii(this.pb,ki));(b=ka(this.K))&&a[t]("?",b);this.hb&&a[t]("#",ii(this.hb,li));return this.N=a[F]("")
        });
    H.C=function(){
        var a=this.ra,b=this.wb,c=this.fb,d=this.Ua,e=this.pb,f=this.K.C(),i=this.hb,k=new gi(h,this.V);a&&k.Ad(a);b&&k.Bd(b);c&&k.rd(c);d&&k.yd(d);e&&k.xd(e);f&&k.zd(f);i&&k.td(i);return k
        };H.Ad=function(a,b){
        this.ia();delete this.N;if(this.ra=b?a?ma(a):"":a)this.ra=this.ra[u](/:$/,"");return this
        };H.Bd=function(a,b){
        this.ia();delete this.N;this.wb=b?a?ma(a):"":a;return this
        };H.rd=function(a,b){
        this.ia();delete this.N;this.fb=b?a?ma(a):"":a;return this
        };
    H.yd=function(a){
        this.ia();delete this.N;if(a){
            a=Number(a);if(na(a)||a<0)aa(Error("Bad port number "+a));this.Ua=a
            }else this.Ua=h;return this
        };H.xd=function(a,b){
        this.ia();delete this.N;this.pb=b?a?ma(a):"":a;return this
        };H.zd=function(a,b){
        this.ia();delete this.N;if(a instanceof hi){
            this.K=a;this.K.Qd=this;this.K.bb(this.V)
            }else{
            b||(a=ii(a,mi));this.K=new hi(a,this,this.V)
            }return this
        };H.ck=function(a,b){
        return this.zd(a,b)
        };H.cb=function(a,b){
        this.ia();delete this.N;this.K.l(a,b);return this
        };
    H.ya=function(a){
        return this.K.A(a)
        };H.td=function(a,b){
        this.ia();delete this.N;this.hb=b?a?ma(a):"":a;return this
        };H.ia=function(){
        if(this.Mi)aa(Error("Tried to modify a read-only Uri"))
            };H.bb=function(a){
        this.V=a;this.K&&this.K.bb(a)
        };
    var ni=/^[a-zA-Z0-9\-_.!~*'():\/;?]*$/,ii=function(a,b){
        var c=h;if(Ad(a)){
            c=a;ni[eb](c)||(c=encodeURI(a));if(c.search(b)>=0)c=c[u](b,oi)
                }return c
        },oi=function(a){
        a=a.charCodeAt(0);return"%"+(a>>4&15)[oc](16)+(a&15)[oc](16)
        },ji=/[#\/\?@]/g,ki=/[\#\?]/g,mi=/[\#\?@]/g,li=/#/g,hi=function(a,b,c){
        this.$=a||h;this.Qd=b||h;this.V=!!c
        };H=hi[y];
    H.ka=function(){
        if(!this.j){
            this.j=new Jf;if(this.$)for(var a=this.$[A]("&"),b=0;b<a[x];b++){
                var c=a[b][w]("="),d=h,e=h;if(c>=0){
                    d=a[b][$c](0,c);e=a[b][$c](c+1)
                    }else d=a[b];d=ye(d);d=this.xa(d);this.add(d,e?ye(e):"")
                }
            }
        };H.j=h;H.h=h;H.add=function(a,b){
        this.ka();this.lb();a=this.xa(a);if(this.ga(a)){
            var c=this.j.A(a);yd(c)?c[t](b):this.j.l(a,[c,b])
            }else this.j.l(a,b);this.h++;return this
        };
    xa(H,function(a){
        this.ka();a=this.xa(a);if(this.j.ga(a)){
            this.lb();var b=this.j.A(a);if(yd(b))this.h-=b[x];else this.h--;return this.j.remove(a)
            }return j
        });Aa(H,function(){
        this.lb();this.j&&this.j[$b]();this.h=0
        });H.ga=function(a){
        this.ka();a=this.xa(a);return this.j.ga(a)
        };H.Ja=function(){
        this.ka();for(var a=this.j.za(),b=this.j.Ja(),c=[],d=0;d<b[x];d++){
            var e=a[d];if(yd(e))for(var f=0;f<e[x];f++)c[t](b[d]);else c[t](b[d])
                }return c
        };
    H.za=function(a){
        this.ka();if(a){
            a=this.xa(a);if(this.ga(a)){
                var b=this.j.A(a);if(yd(b))return b;else{
                    a=[];a[t](b)
                    }
                }else a=[]
                }else{
            b=this.j.za();a=[];for(var c=0;c<b[x];c++){
                var d=b[c];yd(d)?be(a,d):a[t](d)
                }
            }return a
        };H.l=function(a,b){
        this.ka();this.lb();a=this.xa(a);if(this.ga(a)){
            var c=this.j.A(a);if(yd(c))this.h-=c[x];else this.h--
        }this.j.l(a,b);this.h++;return this
        };H.A=function(a,b){
        this.ka();a=this.xa(a);if(this.ga(a)){
            var c=this.j.A(a);return yd(c)?c[0]:c
            }else return b
            };
    Ja(H,function(){
        if(this.$)return this.$;if(!this.j)return"";for(var a=[],b=0,c=this.j.Ja(),d=0;d<c[x];d++){
            var e=c[d],f=xe(e);e=this.j.A(e);if(yd(e))for(var i=0;i<e[x];i++){
                b>0&&a[t]("&");a[t](f);e[i]!==""&&a[t]("=",xe(e[i]));b++
            }else{
                b>0&&a[t]("&");a[t](f);e!==""&&a[t]("=",xe(e));b++
            }
            }return this.$=a[F]("")
        });H.lb=function(){
        delete this.Dc;delete this.$;this.Qd&&delete this.Qd.N
        };H.C=function(){
        var a=new hi;if(this.Dc)a.Dc=this.Dc;if(this.$)a.$=this.$;if(this.j)a.j=this.j.C();return a
        };
    H.xa=function(a){
        a=ka(a);if(this.V)a=a[pd]();return a
        };H.bb=function(a){
        if(a&&!this.V){
            this.ka();this.lb();If(this.j,function(b,c){
                var d=c[pd]();if(c!=d){
                    this.remove(c);this.add(d,b)
                    }
                },this)
            }this.V=a
        };var pi=function(){};H=pi[y];H.Da=[];H.Wb=h;H.Vb=j;H.Rd=j;H.Ik=h;H.Ld=h;H.Md=h;H.kb=function(a,b,c,d){
        if(this.Vb=a&&!b){
            this.Ld=new gi(a);this.Md=h
            }else{
            this.Ld=new gi(a);this.Md=new gi(b)
            }this.Ik=c;this.Rd=d||j
        };
    H.pj=function(a){
        a=fi(a);for(var b=[],c=[],d=new Jf,e=0,f=a[x];e<f;e++){
            var i=a[e],k=new qi({
                languageCode:i.language,
                name:i[cc],
                kind:i.kind,
                is_servable:i.is_servable
                }),s=[];i=i.plaintext_list;for(var z=0,O=i[x];z<O;z++)s[t](new ri(i[z]));b[t](k);c[t](s);d.l(k[oc](),s)
            }return{
            trackMetaDataArray:b,
            trackMap:d
        }
        };H.rj=function(a){
        a=fi(a);for(var b=[],c=0,d=a[x];c<d;c++){
            var e=new qi(a[c]);e.Oe&&b[t](e)
            }return b
        };
    H.sj=function(a){
        var b=a[Ob];if(a&&a[Ob])b=a[Ob].childNodes;else return[];a=[];for(var c=[],d=0,e=b[x];d<e;d++){
            var f=b[d];f[ed]=="track"?a[t](f):c[t](f)
            }b=[];d=0;for(e=a[x];d<e;d++){
            var i=a[d];c=i[Qc]("lang_code");f=i[Qc]("name");i=i[Qc]("kind")||"";b[t](new qi({
                languageCode:c,
                name:f,
                kind:i,
                is_servable:g
            }))
            }return b
        };
    H.Re=function(a){
        var b=new gi(this.Ld),c=this,d={
            method:"GET",
            onComplete:function(e){
                if(c.Vb){
                    e=c.pj(e[mb]);c.Wb=e.trackMap;c.Da=e.trackMetaDataArray
                    }else c.Da=c.Rd?c.sj(e[Sc]):c.rj(e[mb]);a(c.Da)
                }
            };X(b[oc](),d)
        };H.Pe=function(a){
        for(var b=S("LANGUAGE"),c=-1,d=-1,e=0,f=this.Da[x];e<f;e++){
            var i=this.Da[e];if(i.Tb!="asr")if(i.Ub==b){
                c=e;break
            }else if(d<0)d=e
                }b=-1;if(c>=0)b=c;else if(d>=0)b=d;b>=0&&this.Qe(this.Da[b],a)
        };H.qj=function(a){
        a=fi(a);for(var b=[],c=0,d=a[x];c<d;c++)b[t](new ri(a[c]));return b
        };
    H.tj=function(a){
        if(a&&a[Ob])a=a[Ob].childNodes;else return[];for(var b=[],c=0,d=a[x];c<d;c++){
            var e=a[c],f=e[Ob][od],i=ja(e[Qc]("start")||0);e=ja(e[Qc]("dur")||0);b[t](new ri({
                text:f,
                start_ms:i,
                dur_ms:e
            }))
            }return b
        };
    H.Qe=function(a,b){
        if(this.Vb)this.Wb&&this.Wb.ga(a[oc]())&&b(this.Wb.A(a[oc](),[]));else{
            var c=new gi(this.Md);c.K.l("type","track").l("lang",a.Ub).l("name",a.getName()).l("kind",a.Tb);var d=this,e={
                method:"GET",
                onComplete:function(f){
                    f=d.Rd?d.tj(f[Sc]):d.qj(f[mb]);b(f)
                    }
                };X(c[oc](),e)
            }
        };var qi=function(a){
        this.Ub=a.languageCode;this.Tb=a.kind;this.Ra=a[cc];this.Oe=a.is_servable
        };H=qi[y];H.Ub=h;H.Tb=h;H.Ra=h;H.Oe=j;H.getName=function(){
        return this.Ra
        };
    Ja(H,function(){
        return this.Ub+": "+this.Ra+" ("+this.Tb+")"
        });var ri=function(a){
        this.Hd=a.text;this.ub=a.start_ms;this.oe=a.dur_ms||0
        };ri[y].Hd="";ri[y].ub=0;ri[y].oe=0;Ja(ri[y],function(){
        return this.ub+", "+this.oe+": "+this.Hd
        });I("yt.player.Subtitles",pi,void 0);pi[y].initialize=pi[y].kb;pi[y].loadTrackList=pi[y].Re;pi[y].loadTrack=pi[y].Qe;pi[y].loadDefaultTrack=pi[y].Pe;I("yt.player.TimedTextEvent",ri,void 0);var si={},ti=0,ui=function(a){
        var b=new Image,c=""+ti++;si[c]=b;b.onload=b.onerror=function(){
            delete si[c]
        };b.src=a;b=eval("null")
        };var vi=function(a,b){
        var c="a="+a+(b?"&"+b:"")[u](/\//g,"&");ui("/gen_204?"+c);kg(a,b||"null")
        };var wi={},xi=function(a){
        a=a.c();var b=a.b();if(!(b in wi)&&a.qf()){
            a.Va();wi[b]=a
            }
        };var yi=function(){};yi[y].me=j;yi[y].Ga=function(){
        if(!this.me){
            this.me=g;this.u()
            }
        };yi[y].u=function(){};var zi=function(){
        this.Q=[];this.ca={}
        };Kd(zi,yi);H=zi[y];H.pa=1;H.ec=0;H.vf=function(a,b,c){
        var d=this.ca[a];d||(d=this.ca[a]=[]);var e=this.pa;this.Q[e]=a;this.Q[e+1]=b;this.Q[e+2]=c;this.pa=e+3;d[t](e);return e
        };H.Nd=function(a){
        if(this.ec!=0){
            if(!this.qb)this.qb=[];this.qb[t](a);return j
            }var b=this.Q[a];if(b){
            var c=this.ca[b];c&&Zd(c,a);delete this.Q[a];delete this.Q[a+1];delete this.Q[a+2]
        }return!!b
        };
    H.af=function(a){
        var b=this.ca[a];if(b){
            this.ec++;for(var c=ce(arguments,1),d=0,e=b[x];d<e;d++){
                var f=b[d];this.Q[f+1][dd](this.Q[f+2],c)
                }this.ec--;if(this.qb&&this.ec==0)for(;b=this.qb.pop();)this.Nd(b);return d!=0
            }return j
        };Aa(H,function(a){
        if(a){
            var b=this.ca[a];if(b){
                K(b,this.Nd,this);delete this.ca[a]
            }
            }else{
            Ka(this.Q,0);this.ca={}
            }
        });H.u=function(){
        zi.z.u[D](this);delete this.Q;delete this.ca;delete this.qb
        };var Ai={},Bi=function(a){
        var b=vg(a);if(b[ed]!="HTML"){
            a=(a||l[rd])[Zb];if(a in Ai){
                var c=Ai[a];for(var d in c.ca){
                    var e=Df(b,function(f){
                        return N(f,d)
                        },g,a[w]("mouse")!=-1?2:ha);e&&c.af(d,e,a)
                    }
                }
            }
        };U(m,"click",Bi);U(m,"mouseover",Bi);U(m,"mouseout",Bi);var Ci=function(){
        this.ta={}
        };H=Ci[y];H.Xc=!!eval("/*@cc_on!@*/false");H.qf=function(){
        return g
        };H.M=function(a,b,c){
        c=this.b(c);var d=J(b,this);a in Ai||(Ai[a]=new zi);Ai[a].vf(c,d);this.ta[b]=d
        };H.getData=function(a,b){
        return ng(a,b)
        };H.setData=function(a,b,c){
        mg(a,b,c)
        };H.ba=function(a){
        return Ef(a,h,this.b())
        };H.b=function(a){
        return this.$h()+(a?"-"+a:"")
        };H.$h=function(){
        return"yt-uix"+(this.ua?"-"+this.ua:"")
        };var Di=function(){
        this.ta={}
        };Kd(Di,Ci);wd(Di);H=Di[y];H.ua="button";H.Va=function(){
        this.M("click",this.zc)
        };H.zc=function(a){
        var b=this[ub](a,"button-action");if(b)(b=ud(b))&&b[D](h,a);b=this.ib(a);a&&b&&this.Bk(a)
        };H.Bk=function(a){
        var b=this.ib(a);th(b)?this.Rc(a):this.kk(a)
        };
    H.kk=function(a){
        if(a){
            var b=this.ib(a);if(b){
                b.originalParentNode=b[E];b[E][Kc](b);m[Ic][r](b);var c=this.ve(a),d=!!this[ub](a,"button-menu-ignore-group"),e=wh(a),f=e.C();if(c&&!d){
                    var i=wh(c);f.x=i.x
                    }f.y+=a[md]-2;var k=c&&!d?c[pb]-2:a[pb]-2;va(b[C],f.x+"px");b[C].top=f.y+"px";b[C].minWidth=k+"px";V(b);L(a,this.b("active"));c&&L(c,this.b("group-active"));if(N(a,"reverse")){
                    f.y=e.y-b[md]+2;b[C].top=f.y+"px"
                    }if(N(a,"flip")){
                    f.x=c&&!d?i.x+c[pb]:e.x+a[pb];f.x-=b[pb];va(b[C],f.x+"px")
                    }b=J(this.Wi,this,
                    a);b=U(m,"click",b);this[mc](a,"button-listener",b)
                }
            }
        };H.Rc=function(a){
        if(a){
            var b=this.ib(a);if(b){
                W(b);Zf(function(){
                    if(b.originalParentNode){
                        b[E][Kc](b);b.originalParentNode[r](b);b.originalParentNode=h
                        }
                    },1)
                }var c=this.ve(a);M(a,this.b("active"));c&&M(c,this.b("group-active"));if(c=this[ub](a,"button-listener")){
                sg(c);this[mc](a,"button-listener","")
                }
            }
        };H.Af=function(a,b){
        var c=this.ib(a);if(c)o(c,b)
            };H.Wi=function(a,b){
        var c=vg(b);if(!this.Yh(c))if(!this.gi(c)||c[zb]=="SPAN"||N(c,this.b("menu-close")))this.Rc(a)
            };
    H.ib=function(a){
        a.widgetMenu||(a.widgetMenu=lg(h,this.b("menu"),a));return a.widgetMenu
        };H.Yh=function(a){
        return Ef(a,h,this.b())
        };H.gi=function(a){
        return Ef(a,h,this.b("menu"))
        };H.ve=function(a){
        return Ef(a,h,this.b("group"))
        };var Ei=function(){
        this.ta={}
        };Kd(Ei,Ci);wd(Ei);H=Ei[y];H.ua="expander";H.Va=function(){
        this.M("click",this.zc,"head")
        };H.zc=function(a){
        if(a=this.ba(a)){
            he(a,this.b("collapsed"));var b=this[ub](a,"expander-action");if(b)(b=ud(b))&&b[D](h,a)
                }
        };H.collapse=function(a){
        if(a=this.ba(a)){
            L(a,this.b("collapsed"));var b=this[ub](a,"expander-action");if(b)(b=ud(b))&&b[D](h,a)
                }
        };H.expand=function(a){
        if(a=this.ba(a)){
            M(a,this.b("collapsed"));var b=this[ub](a,"expander-action");if(b)(b=ud(b))&&b[D](h,a)
                }
        };var Fi=function(){
        this.ta={}
        };Kd(Fi,Ci);wd(Fi);H=Fi[y];H.ua="tooltip";H.Va=function(){
        this.M("mouseover",this.gd);this.M("mouseout",this.fd)
        };H.qf=function(){
        return!(this.Xc&&/MSIE 6/[eb](fa[Bc]))
        };H.gd=function(a){
        var b=ia(this[ub](a,"tooltip-timer"),10);b&&ag(b);this.uf(a);if(a[qc]){
            this[mc](a,"tooltip-title",a[qc]);La(a,"")
            }
        };H.fd=function(a){
        var b=J(this.Ke,this,a);b=Zf(b,50);this[mc](a,"tooltip-timer",b[oc]());if(b=this[ub](a,"tooltip-title"))La(a,b)
            };
    H.uf=function(a){
        if(a){
            var b=this[ub](a,"tooltip")||a[qc];if(b){
                var c=this.b("tip"),d=c+Fd(a),e=P(d);if(!e){
                    var f=wh(a),i=f.C();i.x+=a[pb]/2;i.y-=3;e=m[Lb]("div");e.id=d;q(e,c);va(e[C],i.x+"px");e[C].top=i.y+"px";c=m[Lb]("div");q(c,this.b("tip-body"));d=m[Lb]("div");q(d,this.b("tip-arrow"));var k=m[Lb]("div");q(k,this.b("tip-content"));o(k,b);c[r](k);e[r](c);e[r](d);m[Ic][r](e);if(N(a,"reverse")){
                        i.y=f.y+a[md]+1;e[C].top=i.y+"px";L(e,this.b("tip-reverse"))
                        }var s=this.b("tip-visible");Zf(function(){
                        L(e,
                            s)
                        },0)
                    }
                }
            }
        };H.Ke=function(a){
        if(a){
            a=this.b("tip")+Fd(a);(a=P(a))&&m[Ic][Kc](a)
            }
        };var Gi=function(a,b){
        var c=P(a);for(c=yf(c);c;){
            b&&b!=c.id&&W(c);c=xf(c[dc],g)
            }
        },Hi=j,Ii=function(a){
        if(!Hi&&(a[Nb]==40||a[Nb]==32||a[Nb]==34))P("masthead-search-term")[sb]();Hi=g
        };var Ji,Ki,Li,Mi,Ni,Oi,Pi,Qi,Ri,Si,Ti,Ui,Vi=g,Wi="",Xi=h,Yi=h,Zi=h,$i=-1,aj=h,bj=h,cj=0,dj=0,ej=h,fj=j,gj=j,hj={
        ja:"co.jp",
        cs:"com"
    },ij=h,jj=h,kj=new RegExp("^[\\s\\u1100-\\u11FF\\u3040-\\u30FF\\u3130-\\u318F\\u31F0-\\u31FF\\u3400-\\u4DBF\\u4E00-\\u9FFF\\uAC00-\\uD7A3\\uF900-\\uFAFF\\uFF65-\\uFFDC]+$"),lj=j,mj=-1,nj="",oj="",pj=10,qj=h,rj=j,sj=fa[Bc][pd](),tj=sj[w]("opera")!=-1,uj=sj[w]("msie")!=-1&&!tj,vj=sj[w]("webkit")!=-1,wj=sj[w]("firefox")!=-1,xj=sj[w]("firefox/3")!=-1,yj=sj[w]("windows")!=-1&&
    (wj||vj)||sj[w]("macintosh")!=-1&&wj&&!xj||tj,zj=function(a){
        if(a.persisted)p(Ri,"f");p(Si,Oi[v])
        },Bj=function(){
        if(Pi){
            var a=lj?20:0;va(Qi,Aj(Oi,"offsetLeft")-a+"px");Qi.top=Aj(Oi,"offsetTop")+Oi[md]-1+"px";qa(Qi,Oi[pb]+a+"px");va(bj,Qi[Ab]);bj.top=Qi.top;qa(bj,Pi[pb]+"px");Ya(bj,Pi[md]+"px")
            }
        },Cj=function(a,b,c){
        var d=m[Lb]("input");za(d,"hidden");Ba(d,a);p(d,b);Ra(d,c);return Ni[r](d)
        },Ej=function(){
        fj||Dj();fj=j
        },Ij=function(a){
        var b=a[Nb];l[B][Nc]=="/"&&Ii(a);if(b==13&&Qi[lc]=="visible"&&Wi==
            Ki&&Zi&&Zi.suggestType){
            Zi.onclick();return j
            }if(b==27&&Qi[lc]=="visible"){
            Dj();Fj(Ki);Ca(a,g);Ua(a,j);return j
            }if(!Gj(b))return g;dj++;dj%3==1&&Hj(b);return j
        },Jj=function(a){
        var b=a[Nb];!(Ui&&Gj(b))&&dj==0&&Hj(b);dj=0;if(Ki[x]>0&&Oi.onkeyup_original){
            Oi.onkeyup_original(a);ge(Pi,"rtl",Oi.dir=="rtl"!=rj)
            }return!Gj(b)
        },Hj=function(a){
        if(Ui&&Gj(a)){
            fj=g;Oi[sb]();Zf(Kj,10)
            }if(Oi[v]!=Ji||a==39){
            Ki=Oi[v];Mi=Lj(Oi);if(a!=39)p(Si,Ki)
                }if(a==40||a==63233)Mj($i+1);else(a==38||a==63232)&&Mj($i-1);Bj();if(Wi!=
            Ki&&!ej)ej=Zf(Dj,500);Ji=Oi[v];Ji==""&&!Xi&&Nj()
        },Gj=function(a){
        return a==38||a==63232||a==40||a==63233
        },Oj=function(){
        Oi[sb]();p(Ri,this.completeId);Fj(this.completeString);qj?qj():Ni.submit()
        },Pj=function(a,b){
        return b?function(){
            Oi[sb]();l[db](a);Zi=h
            }:function(){
            Va(l[B],a)
            }
        },Qj=function(){
        if(!gj){
            if(Zi)q(Zi,"yt-suggest-unselected");q(this,"yt-suggest-selected");Zi=this;if(Yi)for(var a=0;a<Yi[x];a++)if(Yi[a]==Zi){
                $i=a;break
            }
            }
        },Rj=function(){
        if(gj){
            gj=j;Qj[D](this)
            }
        },Mj=function(a){
        if(Wi==""&&
            Ki!=""){
            Li="";Nj()
            }else if(!(Ki!=Wi||!Xi))if(!(!Yi||Yi[x]<=0))if(Qi[lc]=="visible"){
            var b=Yi[x];if(ij)b-=1;if(Zi)q(Zi,"yt-suggest-unselected");if(a==b||a==-1){
                $i=-1;Fj(Ki);Kj();p(Ri,"f")
                }else{
                if(a>b)a=0;else if(a<-1)a=b-1;$i=a;Zi=Yi[wb](a);q(Zi,"yt-suggest-selected");Fj(Zi.completeString);p(Ri,Zi.completeId)
                }
            }else Sj()
            },Dj=function(){
        if(ej){
            ag(ej);ej=h
            }vh(Pi,j);vh(aj,j)
        },Sj=function(){
        if(Vi){
            vh(Pi,g);vh(aj,g);Bj();gj=g
            }
        },Vj=function(a,b,c,d,e,f){
        var i=Pi[bd][x];i!=0&&Pi[bd][i-1][sc]=="yt-suggest-close"&&
        --i;var k=Pi[Cb](i);k.onclick=f;k.onmousedown=Tj;k.onmouseover=Qj;k.onmousemove=Rj;k.completeString=a;k.completeId=c;k.suggestType=d;q(k,"yt-suggest-unselected");if(lj){
            f=m[Lb]("td");q(f,"yt-suggest-icon");k[r](f);if(c=="g"){
                c=m[Lb]("img");c.src="http://www.google.com/favicon.ico";f[r](c)
                }
            }c=m[Lb]("td");if(b)o(c,b);else Uj(c,a);q(c,"yt-suggest-left");if(uj&&kj[eb](a))ta(c[C],"2px");a=m[Lb]("td");e&&Uj(a,e);if(i>0&&Pi[bd][i-1].suggestType!=d)k[C].borderTop="1px solid #CCC";q(a,"yt-suggest-right");
        if(N(Pi,"rtl")){
            k[r](a);k[r](c)
            }else{
            k[r](c);k[r](a)
            }
        },Wj=function(){
        Dj();Ra(Si,g);if(Si[v]!=Oi[v]&&Yi&&Yi[x]&&$i>=0){
            p(Ri,Yi[wb]($i).completeId);Ra(Si,j)
            }else if(cj>=10)p(Ri,"o");return qj?j:g
        },Nj=function(){
        if(!Vi)return j;if(Li!=Ki&&Ki){
            var a=ca(Ki);Zi=h;cj++;var b=m[Lb]("script");b[Ub]("type","text/javascript");b[Ub]("charset","utf-8");b[Ub]("id","jsonpACScriptTagY");b[Ub]("src","http://"+Ti+"&q="+a+"&cp="+Mi);a=m[nb]("jsonpACScriptTagY");var c=m[gc]("head")[0];a&&c[Kc](a);c[r](b);Kj()
            }Li=Ki;
        b=100;for(a=1;a<=(cj-2)/2;++a)b*=2;b+=50;Xi=Zf(Nj,b);return g
        },Fj=function(a){
        p(Oi,a);Ji=a
        },Kj=function(){
        Oi[Kb]()
        },Aj=function(a,b){
        for(var c=0;a;){
            c+=a[b];a=a[yc]
            }return c
        },Uj=function(a,b){
        a[r](m[tb](b))
        };
    function Xj(a){
        for(var b=Pi[bd],c=b[x]-1;c>=0;--c)b[c].completeString&&b[c].completeString[x]==Li[x]&&b[c].completeString==Li[pd]()&&(b[c].suggestType=="mv"||b[c].suggestType=="sh")||Pi.deleteRow(c);var d=0;for(c in a){
            if(d>=pj)break;var e=a[c];if(e){
                d++;var f=e[0],i=e[2];if(e[x]==3){
                    e="";if(d==1)e=jj;var k=h;if(mj!=1){
                        k=Ki[pd]();k=f[u](k,"</b>"+k+"<b>");if(k!=f)k="<b>"+k+"</b>"
                            }Vj(f,k,i,"y",e,Oj)
                    }else if(e[x]==4){
                    var s=e[3];k=s[0];var z=ma(s[1]);e=s[2];s=Pj("/"+s[3],j);if(k=="mv"&&e){
                        e=e[A]("\t");
                        if(e[0])z=z+' <span class="grayText">('+e[0]+")</span>";e=e[x]>1&&e[1]?e[1]:""
                        }Vj(f,z,i,k,e,s)
                    }
                }
            }if(ij&&b[x]>0){
            a=Pi[Cb](-1);a.onmousedown=Tj;b=m[Lb]("td");b.colSpan=lj?3:2;q(a,"yt-suggest-close");c=m[Lb]("span");a[r](b);b[r](c);Uj(c,ij);c.onclick=function(){
                Dj();Wi="";ag(Xi);Xi=h;p(Ri,"x")
                }
            }
        }
    var Tj=function(a){
        if(a&&a[Ac]){
            a[Ac]();Sj();Oi[Kb]()
            }else fj=g;return j
        },Yj=function(){
        var a=Oi[v];a!=Ji&&Hj(0);Ji=a
        },Lj=function(a){
        var b=0,c=0,d;try{
            d=typeof a[Jc]=="number"
            }catch(e){
            d=j
            }if(d){
            b=a[Jc];c=a.selectionEnd
            }if(uj){
            a=a.createTextRange();var f;try{
                f=m.selection.createRange()
                }catch(i){
                f=h
                }if(f&&a.inRange(f)){
                a.setEndPoint("EndToStart",f);b=a.text[x];a.setEndPoint("EndToEnd",f);c=a.text[x]
                }
            }if(b&&c&&b==c)return b;return 0
        },Zj=function(){
        Vi=g;if(Oi){
            Oi[Ub]("autocomplete","off");Nj()
            }
        },$j=
    function(){
        Vi=j;if(Oi){
            Li=Ki;Oi[Ub]("autocomplete","on");Dj()
            }
        };var ak=m[gc]("html")[0],bk=function(){
        var a=!m[Vc]||m[Vc]=="CSS1Compat"?ak:m[Ic];return l.pageYOffset||a[nc]
        },ck=function(){
        if(l[Ib]||!l.ActiveXObject&&!fa.taintEnabled)return l[Hb];return(!m[Vc]||m[Vc]=="CSS1Compat"?ak:m[Ic])[Tc]
        },dk=175,ek=j,fk=function(a,b){
        b=b||bk()+ck();var c;if(!(c=ek)){
            if(m[jc][bb]){
                if(m[jc][bb]){
                    c=a[bb]();var d=m[jc];c=c.top+d[nc]-d[Wb]
                    }else c=0;d=a;for(var e=0;d&&!/^(?:body|html)$/i[eb](d[ed]);){
                    e+=d[nc];d=d[E]
                    }c=c-e
                }else c=0;c=c<=b+dk
            }if(c){
            a.src=a[Qc]("thumb");a.removeAttribute("thumb")
            }
        },
    gk=function(){
        for(var a=m[gc]("IMG"),b=bk()+ck(),c=0;c<a[x];++c)a[c][Qc]("thumb")&&fk(a[c],b)
            };var hk=-1,ik=function(a,b,c,d,e,f,i,k,s,z){
        ag(hk);k=k?k:{};k.session_token=ba(c);c={
            postBody:Lg(k),
            onComplete:function(O){
                var G=P(z?z:"subscribeMessage");O=Ch(O);if(G){
                    o(G,'<div id="subscribeMessage">'+Dh(O,"html_content")+"</div>");V(G)
                    }if(P(d)){
                    W(d);V(e)
                    }if(G&&!s)hk=Zf(function(){
                    W(G)
                    },5E3);i&&i()
                }
            };f=f==0?"/ajax_subscriptions?subscribe_to_":f==1?"/ajax_subscriptions?unsubscribe_from_":"/ajax_subscriptions?get_edit_subscription_form_for_";if(b=="username")X(f+"user="+a,c);else b=="playlist"&&X(f+
            "playlist="+a,c)
        };var jk=function(a){
        a=P(a);for(var b=P(a.id+"-body"),c=yf(a[E]);c;){
            M(c,"watch-tab-sel");c=xf(c[dc],g)
            }L(a,"watch-tab-sel");for(c=yf(b[E]);c;){
            M(c,"watch-tab-sel");c=xf(c[dc],g)
            }L(b,"watch-tab-sel");a[gc]("A")[0][sb]();W("recent-fav-video");W("autoshare-widget-favorite-wizard");W("rec-playlist-video")
        },kk=function(){
        var a=P("watch-main-area")?P("watch-main-area"):P("watch-actions-area");a=R("img","watch-check-grn-circle",a);for(var b=0,c=a[x];b<c;b++)Wa(a[b][C],'url("http://s.ytimg.com/yt/img/check-grn-circle-vfl91176.png")')
            };var lk=function(){
        var a=Vg(this.ee);a&&this.uj(a)
        };wd(lk);var mk=ud("yt.prefs.UserPrefs.prefs_")||{};I("yt.prefs.UserPrefs.prefs_",mk,void 0);H=lk[y];H.ee="PREF";H.uk=function(a){
        if(a==h)aa("ExpectedNotNull")
            };H.vk=function(a,b){
        if(b[eb](a))aa("ExpectedRegexMatch: "+a)
            };H.wk=function(a,b){
        if(!b[eb](a))aa("ExpectedRegexMismatch: "+a)
            };H.Id=function(a){
        this.wk(a,/^\w+$/);this.vk(a,/^f([1-9][0-9]*)$/)
        };H.Cd=function(a,b){
        mk[a]=b[oc]()
        };
    H.xe=function(a){
        a=this.ze(a);return a!=h&&/^[A-Fa-f0-9]+$/[eb](a)?ia(a,16):h
        };H.ze=function(a){
        return mk[a]!==ha?mk[a][oc]():h
        };H.sd=function(a,b,c){
        var d=this.xe(a);d=d!=h?d:0;b=c?d|b:d&~b;b==0?this.je(a):this.Cd(a,b[oc](16))
        };H.Mc=function(a,b){
        var c=this.xe(a);c=c!=h?c:0;return(c&b)>0
        };H.je=function(a){
        delete mk[a]
    };H.uj=function(a){
        a=ba(a)[A]("&");for(var b=0;b<a[x];b++){
            var c=a[b][A]("="),d=c[0];(c=c[1])&&this.Cd(d,c)
            }
        };H.A=function(a,b){
        this.Id(a);var c=this.ze(a);return c!=h?c:b?b:""
        };
    H.l=function(a,b){
        this.Id(a);this.uk(b);this.Cd(a,b)
        };H.wa=function(a){
        return this.Mc("f1",a)
        };H.tb=function(a,b){
        this.sd("f1",a,b)
        };H.Ia=function(a){
        return this.Mc("f2",a)
        };H.ic=function(a,b){
        this.sd("f2",a,b)
        };H.ci=function(a){
        return this.Mc("f3",a)
        };H.Wj=function(a,b){
        this.sd("f3",a,b)
        };xa(H,function(a){
        this.Id(a);this.je(a)
        });H.save=function(a){
        a=(a||7)*24*60*60;Ug(this.ee,this.ne(),a)
        };Aa(H,function(){
        mk={}
        });H.ne=function(){
        var a=[];for(var b in mk)a[t](b+"="+escape(mk[b]));return a[F]("&")
        };
    var nk=lk.c();nk.set=nk.l;nk.get=nk.A;nk.setFlag=nk.tb;nk.getFlag=nk.wa;nk.setFlag2=nk.ic;nk.getFlag2=nk.Ia;xa(nk,nk.remove);nk.save=nk[Dc];Aa(nk,nk[$b]);nk.dump=nk.ne;var Y={};Y.Eg=1;Y.FLAG_SAFE_SEARCH=Y.Eg;Y.sg=2;Y.FLAG_GRID_VIEW_SEARCH_RESULTS=Y.sg;Y.Bb=4;Y.FLAG_EMBED_NO_RELATED_VIDEOS=Y.Bb;Y.eb=8;Y.FLAG_EMBED_SHOW_BORDER=Y.eb;Y.tg=16;Y.FLAG_GRID_VIEW_VIDEOS_AND_CHANNELS=Y.tg;Y.Qg=32;Y.FLAG_WATCH_EXPAND_ABOUT_PANEL=Y.Qg;Y.Sg=64;Y.FLAG_WATCH_EXPAND_MOREFROM_PANEL=Y.Sg;Y.Pg=128;Y.FLAG_WATCH_COLLAPSE_RELATED_PANEL=Y.Pg;Y.Ng=256;Y.FLAG_WATCH_COLLAPSE_PLAYLIST_PANEL=Y.Ng;Y.Og=512;Y.FLAG_WATCH_COLLAPSE_QUICKLIST_PANEL=Y.Og;Y.Rg=1024;
    Y.FLAG_WATCH_EXPAND_ALSOWATCHING_PANEL=Y.Rg;Y.Mg=2048;Y.FLAG_WATCH_COLLAPSE_COMMENTS_PANEL=Y.Mg;Y.Jg=4096;Y.FLAG_STATMODULES_INBOX_COLLAPSED=Y.Jg;Y.Ig=8192;Y.FLAG_STATMODULES_ABOUTYOU_COLLAPSED=Y.Ig;Y.Hg=16384;Y.FLAG_STATMODULES_ABOUTVIDEOS_COLLAPSED=Y.Hg;Y.sc=32768;Y.FLAG_HIDE_WATCH_AUTOSHARE_PROMOTION=Y.sc;Y.zg=65536;Y.FLAG_PERSONALIZED_HOMEPAGE_FEED_FEATURED_COLLAPSED=Y.zg;Y.Cg=131072;Y.FLAG_PERSONALIZED_HOMEPAGE_FEED_RECOMMENDED_COLLAPSED=Y.Cg;Y.Dg=262144;
    Y.FLAG_PERSONALIZED_HOMEPAGE_FEED_SUBSCRIPTIONS_COLLAPSED=Y.Dg;Y.Bg=524288;Y.FLAG_PERSONALIZED_HOMEPAGE_FEED_POPULAR_COLLAPSED=Y.Bg;Y.Ag=1048576;Y.FLAG_PERSONALIZED_HOMEPAGE_FEED_FRIENDTIVITY_COLLAPSED=Y.Ag;Y.Kg=2097152;Y.FLAG_SUGGEST_ENABLED=Y.Kg;Y.wg=4194304;Y.FLAG_HAS_SUGGEST_ENABLED=Y.wg;Y.Lg=8388608;Y.FLAG_WATCH_BETA_PLAYER=Y.Lg;Y.vg=16777216;Y.FLAG_HAS_REDIRECTED_TO_LOCAL_SITE=Y.vg;Y.Td=33554432;Y.FLAG_ACCOUNT_SHOW_PLAYLIST_INFO=Y.Td;Y.xg=67108864;Y.FLAG_HAS_TAKEN_CHANNEL_SURVEY=Y.xg;Y.yg=134217728;
    Y.FLAG_HIDE_TOOLBAR=Y.yg;Y.Gg=268435456;Y.FLAG_SHOWN_LANG_OPT_OUT=Y.Gg;Y.ug=536870912;Y.FLAG_HAS_REDIRECTED_TO_LOCAL_LANG=Y.ug;Y.Fg=1073741824;Y.FLAG_SHOWN_COUNTRY_OPT_OUT=Y.Fg;Y.cg=1;Y.FLAG2_UPLOAD_BETA_OPTSET=Y.cg;Y.bg=2;Y.FLAG2_UPLOAD_BETA_OPTIN=Y.bg;Y.Sd=4;Y.FLAG2_HIDE_MASTHEAD=Y.Sd;Y.$f=8;Y.FLAG2_TV_PARITY=Y.$f;Y.Xf=16;Y.FLAG2_TV_AUTO_FULLSCREEN_OFF=Y.Xf;Y.Yf=32;Y.FLAG2_TV_AUTO_PLAY_NEXT_OFF=Y.Yf;Y.Zf=64;Y.FLAG2_TV_ENABLE_MULTIPLE_CONTROLLERS=Y.Zf;Y.ag=128;Y.FLAG2_TV_RESERVED=Y.ag;Y.Of=256;
    Y.FLAG2_LIGHT_HOMEPAGE=Y.Of;Y.Tf=512;Y.FLAG2_REDLINE_HIDE_TOAST=Y.Tf;Y.Hf=1024;Y.FLAG2_ANNOTATIONS_EDITOR_WATCH_PAGE_DEFAULT_OFF=Y.Hf;Y.Sf=2048;Y.FLAG2_REDLINE_HIDE_START_MESSAGE=Y.Sf;Y.If=4096;Y.FLAG2_ANNOTATIONS_LOAD_POLICY_BY_DEMAND=Y.If;Y.Ab=8192;Y.FLAG2_EMBED_DELAYED_COOKIES=Y.Ab;Y.Kf=16384;Y.FLAG2_HD_TIP_DEMOTE=Y.Kf;Y.Qf=32768;Y.FLAG2_NEWS_TIP_DEMOTE=Y.Qf;Y.dg=65536;Y.FLAG2_UPLOAD_RESTRICT_TIP_DEMOTE=Y.dg;Y.eg=131072;Y.FLAG2_YPP_HIDE_INVITE_SPAM_BOX=Y.eg;Y.fg=262144;
    Y.FLAG2_YPP_HIDE_NEEDS_ADSENSE_BOX=Y.fg;Y.gg=524288;Y.FLAG2_YPP_HIDE_NEEDS_TRAINING_BOX=Y.gg;Y.Wf=1048576;Y.FLAG2_SKIP_CONTRINTER=Y.Wf;Y.zb=2097152;Y.FLAG2_EMBED_DEFAULT_HD=Y.zb;Y.Jf=4194304;Y.FLAG2_ENABLE_FILTER_WORDS=Y.Jf;Y.Rf=8388608;Y.FLAG2_OPTED_IN_FOR_COMMENTS=Y.Rf;Y.Mf=16777216;Y.FLAG2_HQ_SETTING_SAVED=Y.Mf;Y.rc=33554432;Y.FLAG2_HAS_TAKEN_WATCH_PAGE_SURVEY=Y.rc;Y.Vf=67108864;Y.FLAG2_SERVE_MOBILE_HQ_VIDEO=Y.Vf;Y.Uf=134217728;Y.FLAG2_SAFETY_CONTENT_MODE=Y.Uf;Y.Lf=268435456;
    Y.FLAG2_HIDE_PROMO_ACTIVITY_SUBSCRIPTIONS=Y.Lf;Y.Pf=536870912;Y.FLAG2_MOBILE_APP_OPTOUT=Y.Pf;Y.Nf=1073741824;Y.FLAG2_HTML5_BETA=Y.Nf;Y.og=1;Y.FLAG3_LITE_WATCH=Y.og;Y.hg=2;Y.FLAG3_ANNOTATIONS_EDITOR_WATCH_PAGE_DEFAULT_ON=Y.hg;Y.rg=4;Y.FLAG3_WATCH5_OPTIN=Y.rg;Y.jg=8;Y.FLAG3_CAPTIONS_DEFAULT_OFF=Y.jg;Y.ig=16;Y.FLAG3_AUTO_CAPTIONS_DEFAULT_ON=Y.ig;Y.pg=32;Y.FLAG3_LITE_WATCH_OPT_OUT=Y.pg;Y.kg=64;Y.FLAG3_FBPROMO_OPT_OUT=Y.kg;Y.lg=128;Y.FLAG3_HIDE_CHROME_PROMOS=Y.lg;Y.ng=256;
    Y.FLAG3_HOMEPAGE_ALL_VS_SUB_VIEW=Y.ng;Y.qg=512;Y.FLAG3_MYVIDEOSMANAGER_BETA_OPTOUT=Y.qg;Y.mg=1024;Y.FLAG3_HIDE_VIDEO_EDITOR_GUIDED_HELP=Y.mg;var ok={};ok.blank="b1b1b1 cfcfcf";ok.storm="3a3a3a 999999";ok.iceberg="2b405b 6b8ab6";ok.acid="006699 54abd6";ok.green="234900 4e9e00";ok.orange="e1600f febd01";ok.pink="cc2550 e87a9f";ok.purple="402061 9461ca";ok.rubyred="5d1719 cd311b";var pk={};pk["default"]="425 344";pk.medium="480 385";pk.large="640 505";pk.hd720="960 745";var qk={};qk["default"]="560 340";qk.medium="640 385";qk.large="853 505";qk.hd720="1280 745";var uk=function(){
        var a=P("watch-embed-code");if(a){
            var b=P("watch-customize-embed-theme-preview"),c=!P("embed-show-border")[uc]?"_nb":"";b.src="img/customize_player/preview_embed_"+rk+"_sm"+c+".gif";b=S("IS_WIDESCREEN")?qk:pk;for(var d in b){
                c=P("watch-embed-size-text-"+d);var e=sk(d);o(c,e[0]+" &times; "+e[1])
                }p(a,tk())
            }
        },tk=function(){
        var a=lk.c(),b={};if(a.wa(Y.Bb))b.rel="0";var c=a.A("emt");if(c&&c!="blank"){
            c=ok[c][A](" ");b.color1="0x"+c[0];b.color2="0x"+c[1]
            }if(a.Ia(Y.zb))b.hd="1";var d=a.Ia(Y.Ab);
        c=S("EMBED_URL");if(d)c=c[u]("youtube.com","youtube-nocookie.com");if(a.wa(Y.eb))b.border="1";a=sk();b=Mg(c,b);return'<object width="'+a[0]+'" height="'+a[1]+'"><param name="movie" value="'+Ee(b)+'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="'+Ee(b)+'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'+a[0]+'" height="'+a[1]+'"></embed></object>'
        },sk=function(a){
        var b=lk.c(),
        c=a||b.A("ems");a=function(f){
            f=(S("IS_WIDESCREEN")?qk:pk)[f][A](" ");d=ia(f[0],10);e=ia(f[1],10);return[d,e]
            };var d,e;if(!c||c=="custom"){
            b=P("watch-embed-size-custom-width");b=ia(b[v],10)||0;c=P("watch-embed-size-custom-height");c=ia(c[v],10)||0;a=b>=200&&c>0?[b,c]:a("default");d=a[0];e=a[1]
            }else{
            a=a(c);d=a[0];e=a[1];if(b.wa(Y.eb)){
                d+=20;e+=20
                }
            }return[d,e]
        },xk=function(){
        if(P("watch-customize-embed")){
            var a=lk.c();Oa(P("embed-show-border"),a.wa(Y.eb));Oa(P("embed-show-related"),!a.wa(Y.Bb));Oa(P("embed-delayed-cookies"),
                a.Ia(Y.Ab));var b=P("embed-use-hd");if(b)Oa(b,a.Ia(Y.zb));(b=a.A("emt"))&&vk(b);(a=a.A("ems"))&&a!="small"?wk(a):wk("medium");uk()
            }
        },rk="blank",yk="default",vk=function(a){
        var b=P("watch-embed-theme-"+rk),c=P("watch-embed-theme-"+a),d=lk.c();d.l("emt",a);d[Dc]();M(b,"radio-selected");L(c,"radio-selected");rk=a;uk();return j
        },wk=function(a){
        var b=P("watch-embed-size-radio-"+yk),c=P("watch-embed-size-radio-"+a),d=lk.c();d.l("ems",a);d[Dc]();M(b,"radio-selected");L(c,"radio-selected");c[sb]();yk=a;b=
        P("embed-use-hd");if(a!="hd720"&&b)Oa(b,j);if(a!="custom"){
            a=P("watch-embed-size-custom-width");b=P("watch-embed-size-custom-height");p(a,"");p(b,"")
            }uk();return j
        },zk=function(a){
        var b=a||h;a=P("watch-embed-size-custom-width");var c=P("watch-embed-size-custom-height");if(b||a[v]){
            var d=0;if(P("embed-show-border")[uc])d=20;var e=sk("medium");e=(e[0]-d)/(e[1]-25-d);if(b==c){
                b=ia(c[v],10)||1;b=n[lb]((b-d-25)*e);if(b<0)b=0;p(a,b+d)
                }else{
                b=ia(a[v],10)||1;b=n[lb]((b-d)/e)+25+d;if(b<0)b=0;p(c,b)
                }uk()
            }
        };var Ak=j,Bk=h,Dk=function(a,b){
        b||Ck();var c=!!a,d=P("content"),e=P("watch-sidebar"),f=P("watch-video"),i=P("baseDiv"),k=S("WIDE_PLAYER_STYLES"),s=0;if("webkitTransition"in e[C]){
            e=m[bc].getComputedStyle(e,h);s=ja(e["-webkit-transition-duration"])*1E3
            }e=P("movie_player");if(c){
            s=s;L(d,"watch-wide");Zf(function(){
                L(f,"wide");for(var O=0;O<k[x];++O)L(i,k[O])
                    },s);e&&e.getPlaybackQuality()=="medium"&&!S("PREFER_LOW_QUALITY")&&e.setPlaybackQuality("large")
            }else{
            s=s/2;M(f,"wide");for(var z=0;z<k[x];++z)M(i,
                k[z]);Zf(function(){
                M(d,"watch-wide")
                },s);e&&e.getPlaybackQuality()=="large"&&e.setPlaybackQuality("medium")
            }sh("masthead-utility-menulink-short",c);sh("masthead-utility-menulink-long",!c)
        },Ek=function(){
        var a=P("watch-video");return a?N(a,"wide"):j
        },Gk=function(){
        if(!S("LOGGED_IN")){
            o(P("watch-actions-area"),P("watch-actions-close")[ob]+P("watch-actions-logged-out")[ob]);Fk();return j
            }return g
        },Hk=function(){
        if(S("REQUIRES_RENTAL_PURCHASE")){
            o(P("watch-actions-area"),P("watch-actions-close")[ob]+
                P("watch-actions-rental-required")[ob]);Fk();return g
            }return j
        },Ik=j,Jk=[],Kk=-1,Lk=0,Ok=function(a){
        Jk=a;var b=P("watch-captions-container"),c=m[Lb]("div");c.id="captions-scrollbox";U(c,"mouseover",function(){
            Ik=g
            });U(c,"mouseout",function(){
            Ik=j
            });b[r](c);var d=0;for(d=0;d<a[x];++d){
            var e=a[d],f=m[Lb]("div"),i=e.ub/1E3;f.id="cp-"+d;q(f,"cpline");mg(f,"time",i+"");f.onmousedown=function(s){
                Mk().seekTo(ng(this,"time"),g);return yg(s)
                };c[r](f);var k=m[Lb]("div");q(k,"cptime");o(k,n[lb](i/60)+":"+(i%
                60<10?"0":"")+n[lb](i%60));f[r](k);i=m[Lb]("div");q(i,"cptext");o(i,e.Hd);f[r](i)
            }L(P("watch-captions-loading"),"hid");Ya(b[C],c[md]+10+"px");$f(Nk,500)
        },Mk=function(){
        return P("movie_player")||P("video-player")
        },Nk=function(){
        for(var a=Mk().getCurrentTime(),b=Jk,c=Kk,d=c;;)if(a+0.5<(d>=0?b[d].ub/1E3:-1))d-=1;else if(a+0.5>(d+1<b[x]?b[d+1].ub/1E3:1E6))d+=1;else break;if(d!=c){
            c>=0&&M(P("cp-"+c),"cpline-highlight");d>=0&&L(P("cp-"+d),"cpline-highlight");Kk=d;Ik||Pk(P("cp-"+(d>=3?d-3:0)))
            }
        },Pk=function(a){
        bg(Lk);
        var b=P("captions-scrollbox"),c=n.min(a[jd]-b[jd],b[Mb]-b[md]),d=0;Lk=$f(function(){
            var e=c-b[nc],f=n[ib](2*e*50/(1E3-50*d));if(n.abs(e)<=n.abs(f)||d>20){
                Ia(b,c);bg(Lk)
                }else{
                b.scrollTop+=f;d++
            }
            },50)
        },Rk=function(){
        Qk(h,g)
        },Qk=function(a,b){
        var c=P("watch-actions-area-container");if(!N(c,"collapsed")&&R("INPUT","watch-actions-share-input",c)[x])Sk();else{
            Sk();Tk();o(P("watch-actions-area"),P("watch-actions-close")[ob]+P("watch-actions-share")[ob]);L(P("watch-share"),"active");var d=lg("DIV","watch-actions-share",
                c);L(d,"active");Zf(function(){
                var e=lg("INPUT","watch-actions-share-input",c);e[Kb]();e[Pb]()
                },0);b?vi("shareOpenedFromFlash"):vi("shareOpenedFromActionBar");Uk()
            }
        },Uk=function(){
        var a=P("watch-actions-area-container"),b=lg("DIV","watch-actions-share",a);if(b){
            a=lg("input","watch-actions-share-input",b);var c=lg("input","watch-actions-share-hd",b);b=(b=lg("input","watch-actions-share-short",b))&&b[uc]?S("SHARE_URL_SHORT"):S("SHARE_URL");var d={};if(c&&c[uc])d.hd="1";p(a,Mg(b,d))
            }
        },Tk=function(){
        o(P("watch-actions-area"),
            T("LOADING"));Fk()
        },Fk=function(){
        var a=P("watch-actions-area-container"),b=P("watch-actions-area");M(a,"collapsed");Zf(function(){
            Ya(a[C],P("inappropriateMainDiv")?"565px":b[md]+1+"px")
            },0)
        },Sk=function(){
        var a=P("watch-actions-area-container"),b=P("watch-actions-area");L(a,"collapsed");a=["watch-like","watch-unlike","watch-share","watch-embed","watch-flag"];for(var c=0;c<a[x];++c){
            var d=P(a[c]);d&&M(d,"active")
            }o(b,T("LOADING"))
        },Vk=function(a,b,c){
        var d=ng(a,"expander-ajax-link");if(d){
            var e=R(h,
                "watch-module-expanded-title-wrapper",a)[0];L(e,"list-action-pending");var f=P(a.id+"-body");if(c)if(c=S("SHUFFLE_ENABLED")?"&shuffle="+S("SHUFFLE_VALUE"):"")d+=c;Ah(d,function(i){
                o(f,i[mb]);mg(a,"loaded","true");switch(b||1){
                    case 1:if(i=lg(h,"next-list-current",f))Ia(f,i[jd]);break;case 2:Ia(f,f[Mb]);break;case 3:break
                        }i=R(h,"watch-module-expanded-title-wrapper",a)[0];M(i,"list-action-pending");if(S("HAS_ACTIVE_QUICKLIST")||a.id=="watch-passive-QL"){
                    i=P(a.id+"-body");ud("yt.www.watch.quicklistdragdrop").init(i);
                    i=ae(R("li","edit-list-item",i));for(var k=0;k<i[x];k++)ud("yt.www.watch.quicklistdragdrop").addQuicklistRow(i[k])
                        }gk()
                })
            }
        },Wk=function(a,b){
        var c=lg("h3","yt-uix-expander-head",a);he(c,"yt-rounded-bottom");if(!ng(a,"loaded")||ng(a,"loaded")=="false")Vk(a,b)
            },Xk=function(a){
        a=a||"";return a+"&"+S("XSRF_QL_PAIR")
        },Yk=function(){
        return S("HAS_ACTIVE_QUICKLIST")?P("watch-next-list"):P("watch-passive-QL")
        },Zk=h,bl=function(a,b,c,d){
        l.scroll(0,0);p(P("masthead-search-term"),a);$k()||(Ak=Ek());try{
            Dk(j,
                g)
            }catch(e){}var f=Ei.c(),i=P("page"),k=P("pagetop")||P("watch-pagetop-section"),s=P("watch-search"),z=P("footer-container"),O=P("watch-panel"),G=P("watch-branded-actions"),Q=Yk();if(!$k()){
            Bk=xf(Q[dc],g);L(i,"search-mode");Ve?L(i,"search-mode-ff"):L(i,"search-mode-std");(i=P("movie_player"))&&i.startAutoHideControls&&i.startAutoHideControls();wf(s);wf(z);k[r](s);k[r](z);wf(Q);s[r](Q);if(G&&O){
                wf(G);O[r](G)
                }if(c=="disco"){
                L(Q,"disco");V(Q);f.expand(Q)
                }else W(Q)
                }V(s);V("watch-search-body-loading");
        W("watch-search-body");al();o(P("watch-search-options"),"");o(P("watch-search-count"),"");o(P("watch-search-query"),a);a=m[$a].searchForm;try{
            Wj()
            }catch(ga){}f.collapse(P("watch-video-count"));var Da;if(S("AJAX_MODE")){
            Da=Kg(l[B][ab]);if(Da.v)Zk=Da.v
                }f={
            method:"GET",
            onComplete:function(){
                if(S("AJAX_MODE")){
                    var Yc=Kg(l[B][ab]);if(Yc.q!=Da.q||Yc[cb]!=Da[cb])return
                }W("watch-search-body-loading");V("watch-search-body");if(P("watch-search-count-hidden"))o(P("watch-search-count"),P("watch-search-count-hidden")[ob]);
                if(P("watch-search-options-hidden"))o(P("watch-search-options"),P("watch-search-options-hidden")[ob]);W("ad_creative_1");gk()
                },
            update:"watch-search-body"
        };k=a[cd];if(c)k="/"+c;c=Nf(a);c+="&ajax=1";c+="&nocache="+((new Date)[fc]()+ia(n[Pc]()*1234567,10));if(b)c+="&page="+b;if(d){
            W("watch-search-body-loading");V("watch-search-body");if(P("watch-search-count-hidden"))o(P("watch-search-count"),P("watch-search-count-hidden")[ob]);if(P("watch-search-options-hidden"))o(P("watch-search-options"),P("watch-search-options-hidden")[ob]);
            gk()
            }else X(k+"?"+c,f);$j();Zf(Zj,100)
        },$k=function(){
        return N(P("page"),"search-mode")
        },cl=0,al=function(){
        if(Ve)if($k()){
            cl&&ag(cl);cl=Zf(function(){
                var a=P("pagetop")||P("watch-pagetop-section"),b=P("content"),c=l[Hb]?l[Hb]:m[Ic][Tc],d=b[md],e=b[C].paddingTop;if(e){
                    e=ia(e[Fb](/([0-9]+)px/)[1],10);d-=e
                    }c=c-d-8;Ya(a[C],c+"px");ta(b[C],c+"px")
                },50)
            }
        },Ck=function(){
        var a=Kg(l[B][ab]);if(S("AJAX_MODE")&&a.q){
            delete a.q;delete a[cb];a.v=Zk;oa(l[B],"#!"+Lg(a))
            }else dl()
            },dl=function(){
        var a=P("page"),
        b=P("watch-search"),c=P("footer-container"),d=P("pagetop")||P("watch-pagetop-section"),e=P("content"),f=P("watch-video"),i=P("watch-branded-actions"),k=P("watch-sidebar"),s=Yk();if($k()){
            M(a,"search-mode");Ve?M(a,"search-mode-ff"):M(a,"search-mode-std");(a=P("movie_player"))&&a.stopAutoHideControls&&a.stopAutoHideControls();Ya(d[C],"");ta(e[C],"");W(b);wf(b);wf(c);e[r](b);e[r](c);b=Bk||yf(k);wf(s);b[E]&&b[E][xb](s,b);if(i&&f){
                wf(i);f[r](i)
                }
            }Bk=h;Ak&&Dk(g,g);Ak=j;if((f=P("watch-next-list"))&&S("HAS_ACTIVE_QUICKLIST")){
            M(f,
                "disco");V(f)
            }if(f=P("watch-passive-QL")){
            M(f,"disco");if(!ia(P("watch-passive-QL-count")[ob],10)||S("HAS_ACTIVE_QUICKLIST"))W(f)
                }
        },el=function(a){
        var b=P("subscribeDiv"),c=Fi.c();c[mc](b,"tooltip",a);c.uf(b);Zf(function(){
            c.Ke(b);c[mc](b,"tooltip","")
            },6E3)
        };var fl,gl,hl=function(){
        var a=uf("script");za(a,"text/javascript");a.src="http://www.google.com/support/youtube/bin/resource/guide_inproduct.js?v="+Jd();m[Ic][r](a)
        },il=function(){
        fl=j;var a=P("staged-player");W(a);wf(a);ge(gl,"player-hid",j)
        },jl=function(a){
        a=a||S("GUIDED_HELP_FLOW");var b;if(!(b=fl)){
            b=P("watch-player");b=!(b?N(b,"flash-player"):j)
            }if(!b){
            l.guidedhelp.onFlowDismiss=il;l.guidedhelp.onFlowLoadFailure=il;fl=g;if(!(b=P("staged-player"))){
                b=uf("div");b.id="staged-player";var c=uf("img");
                c.src=S("VIDEO_HQ_THUMB");c.id="staged-screenshot";var d=uf("img");q(d,"staged-player-controls");d.src=Ek()?S("STAGED_WIDE_PLAYER_CONTROLS_URI"):S("STAGED_PLAYER_CONTROLS_URI");b[r](c);b[r](d);c=uf("div");c.id="staged-quality-size-controls";b[r](c);c=P("watch-video");W(b);c[r](b);b=b
                }b=b;P("movie_player").pauseVideo();gl=c=P("watch-player");ge(c,"player-hid",g);V(b)
            }if(a)ud("help.guide.loadFlow")(a);else(a=ud("help.guide.optionallyResume"))&&a()
            };var kl,ml=function(a,b,c){
        this.nb=a;if(ll)this.Sc=b;this.qc=c||l;this.Xb=this.qc[B];this.nh=this.Xb[Zc][A]("#")[0];this.Zd=J(this.xk,this)
        },nl=Ue&&m.documentMode>=8||Ve&&ff("1.9.2")||We&&ff("532.1"),ll=Ue&&!nl;H=ml[y];H.Tj=function(a,b){
        if(this.cd){
            sg(this.cd);delete this.cd
            }if(this.Uc){
            bg(this.Uc);delete this.Uc
            }if(a){
            this.U=this.Nc();if(ll){
                var c=this.Sc[ec][wc][Ic];if(!c||!c[ob])this.ud(this.U)
                    }b||this.nb(this.U);if(nl)this.cd=U(this.qc,"hashchange",this.Zd);else this.Uc=$f(this.Zd,200)
                }
        };
    H.Bi=function(){
        if(ll){
            var a=this.ei();if(a!=this.U){
                this.U=a;this.of(a);this.nb(a)
                }else{
                a=this.Nc();if(a!=this.U){
                    this.U=a;this.ud(a);this.nb(a)
                    }
                }
            }else{
            a=this.Nc();if(a!=this.U){
                this.U=a;this.nb(a)
                }
            }
        };H.xk=function(){
        this.Bi()
        };H.Nc=function(){
        var a=this.Xb[Zc],b=a[w]("#");return b<0?"":a[$c](b+1)
        };H.of=function(a){
        a=this.nh+"#"+a;var b=this.Xb[Zc];if(!(b==a||b+"#"==a))Va(this.Xb,a)
            };H.ei=function(){
        var a=this.Sc[ec][wc][Ic];return a?ye(a[ob][$c](1)):""
        };
    H.ud=function(a,b){
        var c=this.Sc[ec][wc],d=c[Ic]?c[Ic][ob]:"",e="#"+xe(a);if(d!=e){
            d=["<title>",Ee(b||l[wc][qc]||""),"</title><body>",e,"</body>"];c[db]("text/html");c[Bb](d[F](""));c[Hc]()
            }
        };H.add=function(a,b,c){
        this.U=ka(a);ll&&this.ud(a,b);this.of(a);c||this.nb(this.U)
        };var ol=ud("yt.pubsub.instance_")||new zi;zi[y].subscribe=zi[y].vf;zi[y].unsubscribeByKey=zi[y].Nd;zi[y].publish=zi[y].af;Aa(zi[y],zi[y][$b]);I("yt.pubsub.instance_",ol,void 0);var pl=function(a,b,c){
        var d=ud("yt.pubsub.instance_");return d?d.subscribe(a,function(){
            var e=arguments;Zf(function(){
                b[dd](c||sd,e)
                },0)
            },c):0
        },ql=function(){
        var a=ud("yt.pubsub.instance_");return a?a.publish[dd](a,arguments):j
        };var sl=function(a){
        var b=rl();b.setEnabled[D](b,g,a)
        },tl=function(){
        var a=rl();a.setEnabled[D](a,j)
        },rl=function(){
        var a=ud("yt.history.instance_");if(!a){
            a=P("legacy-history-iframe");kl=a=new ml(ul,a);ml[y].setEnabled=ml[y].Tj;ml[y].add=ml[y].add;I("yt.history.instance_",kl,void 0)
            }return a
        },ul=function(a){
        ql("navigate",a)
        };var vl={},wl={},xl=function(a){
        var b=j;if(a in vl&&!wl[a]){
            K(vl[a],function(c){
                var d=c[0];c=c[1];if(d&&d[ed]=="IMG"){
                    d.onload="";d.src=c;b=g
                    }else b=j
                    });wl[a]=g
            }return b
        };var yl=function(a,b){
        za(this,a);Sa(this,b);ua(this,this[Mc])
        };Kd(yl,yi);H=yl[y];H.u=function(){
        delete this[Zb];delete this[Mc];delete this.currentTarget
        };H.qa=j;H.Ya=g;Pa(H,function(){
        this.qa=g
        });sa(H,function(){
        this.Ya=j
        });var zl=function(a,b){
        a&&this.oa(a,b)
        };Kd(zl,yl);H=zl[y];Sa(H,h);pa(H,h);H.offsetX=0;H.offsetY=0;Fa(H,0);Ga(H,0);H.screenX=0;H.screenY=0;H.button=0;ya(H,0);wa(H,0);H.ctrlKey=j;H.altKey=j;H.shiftKey=j;H.metaKey=j;H.vj=j;H.D=h;
    H.oa=function(a,b){
        var c=za(this,a[Zb]);Sa(this,a[Mc]||a.srcElement);ua(this,b);var d=a.relatedTarget;if(d){
            if(Ve)try{
                d=d[zb]&&d
                }catch(e){
                d=h
                }
            }else if(c=="mouseover")d=a.fromElement;else if(c=="mouseout")d=a.toElement;pa(this,d);this.offsetX=a.offsetX!==ha?a.offsetX:a.layerX;this.offsetY=a.offsetY!==ha?a.offsetY:a.layerY;Fa(this,a[hc]!==ha?a[hc]:a.pageX);Ga(this,a[ic]!==ha?a[ic]:a.pageY);this.screenX=a[Db]||0;this.screenY=a[Eb]||0;this.button=a.button;ya(this,a[Nb]||0);wa(this,a.charCode||(c=="keypress"?
            a[Nb]:0));this.ctrlKey=a.ctrlKey;this.altKey=a.altKey;this.shiftKey=a.shiftKey;this.metaKey=a.metaKey;this.vj=Oe?a.metaKey:a.ctrlKey;this.D=a;delete this.Ya;delete this.qa
        };Pa(H,function(){
        this.qa=g;if(this.D[Ac])this.D[Ac]();else Ca(this.D,g)
            });var Al=Ue&&!ff("8");sa(zl[y],function(){
        this.Ya=j;var a=this.D;if(a[vb])a[vb]();else{
            Ua(a,j);if(Al)try{
                if(a.ctrlKey||a[Nb]>=112&&a[Nb]<=123)ya(a,-1)
                    }catch(b){}
                }
        });zl[y].u=function(){
        zl.z.u[D](this);this.D=h;Sa(this,h);ua(this,h);pa(this,h)
        };var Bl=function(){},Cl=0;H=Bl[y];H.key=0;H.Xa=j;H.ae=j;H.oa=function(a,b,c,d,e,f){
        if(Bd(a))this.Ne=g;else if(a&&a[Xb]&&Bd(a[Xb]))this.Ne=j;else aa(Error("Invalid listener argument"));this.mb=a;this.$e=b;this.src=c;za(this,d);this.capture=!!e;this.Qc=f;this.ae=j;this.key=++Cl;this.Xa=j
        };H.handleEvent=function(a){
        if(this.Ne)return this.mb[D](this.Qc||this.src,a);return this.mb[Xb][D](this.mb,a)
        };var Dl=function(a,b){
        this.Te=b;this.va=[];this.Dh(a)
        };Kd(Dl,yi);H=Dl[y];H.Cc=h;H.le=h;H.sb=function(a){
        this.Cc=a
        };H.Ka=function(){
        if(this.va[x])return this.va.pop();return this.fe()
        };H.Wa=function(a){
        this.va[x]<this.Te?this.va[t](a):this.ke(a)
        };H.Dh=function(a){
        if(a>this.Te)aa(Error("[goog.structs.SimplePool] Initial cannot be greater than max"));for(var b=0;b<a;b++)this.va[t](this.fe())
            };H.fe=function(){
        return this.Cc?this.Cc():{}
        };H.ke=function(a){
        if(this.le)this.le(a);else if(Bd(a.Ga))a.Ga();else for(var b in a)delete a[b]
            };
    H.u=function(){
        Dl.z.u[D](this);for(var a=this.va;a[x];)this.ke(a.pop());delete this.va
        };var El;var Fl=(El="ScriptEngine"in sd&&sd.ScriptEngine()=="JScript")?sd.ScriptEngineMajorVersion()+"."+sd.ScriptEngineMinorVersion()+"."+sd.ScriptEngineBuildVersion():"0";var Gl,Hl,Il,Jl,Kl,Ll,Ml,Nl,Ol,Pl,Ql;
    (function(){
        function a(){
            return{
                h:0,
                P:0
            }
            }function b(){
            return[]
            }function c(){
            var Q=function(ga){
                return i[D](Q.src,Q.key,ga)
                };return Q
            }function d(){
            return new Bl
            }function e(){
            return new zl
            }var f=El&&!(Ie(Fl,"5.7")>=0),i;Ll=function(Q){
            i=Q
            };if(f){
            Gl=function(){
                return k.Ka()
                };Hl=function(Q){
                k.Wa(Q)
                };Il=function(){
                return s.Ka()
                };Jl=function(Q){
                s.Wa(Q)
                };Kl=function(){
                return z.Ka()
                };Ml=function(){
                z.Wa(c())
                };Nl=function(){
                return O.Ka()
                };Ol=function(Q){
                O.Wa(Q)
                };Pl=function(){
                return G.Ka()
                };Ql=function(Q){
                G.Wa(Q)
                };
            var k=new Dl(0,600);k.sb(a);var s=new Dl(0,600);s.sb(b);var z=new Dl(0,600);z.sb(c);var O=new Dl(0,600);O.sb(d);var G=new Dl(0,600);G.sb(e)
            }else{
            Gl=a;Hl=vd;Il=b;Jl=vd;Kl=c;Ml=vd;Nl=d;Ol=vd;Pl=e;Ql=vd
            }
        })();var Rl={},Sl={},Tl={},Ul={},Vl=function(a,b,c,d,e){
        if(b)if(yd(b)){
            for(var f=0;f<b[x];f++)Vl(a,b[f],c,d,e);return h
            }else{
            d=!!d;var i=Sl;b in i||(i[b]=Gl());i=i[b];if(!(d in i)){
                i[d]=Gl();i.h++
            }i=i[d];var k=Fd(a),s;i.P++;if(i[k]){
                s=i[k];for(f=0;f<s[x];f++){
                    i=s[f];if(i.mb==c&&i.Qc==e){
                        if(i.Xa)break;return s[f].key
                        }
                    }
                }else{
                s=i[k]=Il();i.h++
            }f=Kl();f.src=a;i=Nl();i.oa(c,f,a,b,d,e);c=i.key;f.key=c;s[t](i);Rl[c]=i;Tl[k]||(Tl[k]=Il());Tl[k][t](i);if(a[Sb]){
                if(a==sd||!a.he)a[Sb](b,f,d)
                    }else a[ac](Wl(b),f);
            return c
            }else aa(Error("Invalid event type"))
            },Xl=function(a,b,c,d,e){
        if(yd(b)){
            for(var f=0;f<b[x];f++)Xl(a,b[f],c,d,e);return h
            }d=!!d;a:{
            f=Sl;if(b in f){
                f=f[b];if(d in f){
                    f=f[d];a=Fd(a);if(f[a]){
                        a=f[a];break a
                    }
                    }
                }a=h
            }if(!a)return j;for(f=0;f<a[x];f++)if(a[f].mb==c&&a[f][yb]==d&&a[f].Qc==e)return Yl(a[f].key);return j
        },Yl=function(a){
        if(!Rl[a])return j;var b=Rl[a];if(b.Xa)return j;var c=b.src,d=b[Zb],e=b.$e,f=b[yb];if(c[xc]){
            if(c==sd||!c.he)c[xc](d,e,f)
                }else c.detachEvent&&c.detachEvent(Wl(d),e);c=
        Fd(c);e=Sl[d][f][c];if(Tl[c]){
            var i=Tl[c];Zd(i,b);i[x]==0&&delete Tl[c]
        }b.Xa=g;e.Ve=g;Zl(d,f,c,e);delete Rl[a];return g
        },Zl=function(a,b,c,d){
        if(!d.Yb)if(d.Ve){
            for(var e=0,f=0;e<d[x];e++)if(d[e].Xa){
                var i=d[e].$e;i.src=h;Ml(i);Ol(d[e])
                }else{
                if(e!=f)d[f]=d[e];f++
            }Ka(d,f);d.Ve=j;if(f==0){
                Jl(d);delete Sl[a][b][c];Sl[a][b].h--;if(Sl[a][b].h==0){
                    Hl(Sl[a][b]);delete Sl[a][b];Sl[a].h--
                }if(Sl[a].h==0){
                    Hl(Sl[a]);delete Sl[a]
                }
                }
            }
        },$l=function(a,b,c){
        var d=0,e=a==h,f=b==h,i=c==h;c=!!c;if(e)le(Tl,function(s){
            for(var z=
                s[x]-1;z>=0;z--){
                var O=s[z];if((f||b==O[Zb])&&(i||c==O[yb])){
                    Yl(O.key);d++
                }
                }
            });else{
            a=Fd(a);if(Tl[a]){
                a=Tl[a];for(e=a[x]-1;e>=0;e--){
                    var k=a[e];if((f||b==k[Zb])&&(i||c==k[yb])){
                        Yl(k.key);d++
                    }
                    }
                }
            }return d
        },Wl=function(a){
        if(a in Ul)return Ul[a];return Ul[a]="on"+a
        },bm=function(a,b,c,d,e){
        var f=1;b=Fd(b);if(a[b]){
            a.P--;a=a[b];if(a.Yb)a.Yb++;else a.Yb=1;try{
                for(var i=a[x],k=0;k<i;k++){
                    var s=a[k];if(s&&!s.Xa)f&=am(s,e)!==j
                        }
                }finally{
                a.Yb--;Zl(c,d,b,a)
                }
            }return Boolean(f)
        },am=function(a,b){
        var c=a[Xb](b);
        a.ae&&Yl(a.key);return c
        };
    Ll(function(a,b){
        if(!Rl[a])return g;var c=Rl[a],d=c[Zb],e=Sl;if(!(d in e))return g;e=e[d];var f,i;if(Ue){
            f=b||ud("window.event");var k=g in e,s=j in e;if(k){
                if(f[Nb]<0||f.returnValue!=ha)return g;a:{
                    var z=j;if(f[Nb]==0)try{
                        ya(f,-1);break a
                    }catch(O){
                        z=g
                        }if(z||f.returnValue==ha)Ua(f,g)
                        }
                }z=Pl();z.oa(f,this);f=g;try{
                if(k){
                    for(var G=Il(),Q=z.currentTarget;Q;Q=Q[E])G[t](Q);i=e[g];i.P=i.h;for(var ga=G[x]-1;!z.qa&&ga>=0&&i.P;ga--){
                        ua(z,G[ga]);f&=bm(i,G[ga],d,g,z)
                        }if(s){
                        i=e[j];i.P=i.h;for(ga=0;!z.qa&&ga<G[x]&&
                            i.P;ga++){
                            ua(z,G[ga]);f&=bm(i,G[ga],d,j,z)
                            }
                        }
                    }else f=am(c,z)
                    }finally{
                if(G){
                    Ka(G,0);Jl(G)
                    }z.Ga();Ql(z)
                }return f
            }d=new zl(b,this);try{
            f=am(c,d)
            }finally{
            d.Ga()
            }return f
        });var cm=function(a,b,c){
        c=c||"";Qa(l,Mg(a,b||{})+c)
        },dm=function(a,b){
        var c=b||{};Sa(c,c[Mc]||a[Mc]||"YouTube");qa(c,c[hb]||600);Ya(c,c[kd]||600);var d=c;d||(d={});var e=l;c=typeof a[Zc]!="undefined"?a[Zc]:ka(a);var f=d[Mc]||a[Mc],i=[];for(var k in d)switch(k){
            case "width":case "height":case "top":case "left":i[t](k+"="+d[k]);break;case "target":case "noreferrer":break;default:i[t](k+"="+(d[k]?1:0))
                }k=i[F](",");if(d.noreferrer){
            if(d=e[db]("",f,k)){
                d[wc][Bb]('<META HTTP-EQUIV="refresh" content="0; url='+
                    Ee(c)+'">');d[wc][Hc]()
                }
            }else d=e[db](c,f,k);c=d;if(!c)return g;if(!c.opener)c.opener=l;c[Kb]();return j
        };var Z=function(a,b,c,d,e,f,i){
        this.Pj=a;this.rb="session_token="+a;if((this.r=b)&&this.r[rb](this.r[x]-1)!="/")this.r+="/";this.Qi=c;this.L=d;this.Wc=e;this.Sh=f;this.Dk=i;this.Vc=j;this.cc=h;this.qd=[];this.Lc=[];this.xc=[];this.kf={}
        };I("yt.sharing.AutoShare",Z,void 0);Z[y].Cj=function(a,b){
        Vl(a,"click",this.Be,j,this);if(a.id)this.kf[a.id]=b;else aa("Connect dialog launch buttons must have an id.")
            };Z[y].registerConnectDialogLauncher=Z[y].Cj;
    Z[y].Be=function(a){
        (a=this.kf[a.currentTarget.id])&&this.Ac(a,g)
        };Z[y].handleConnectService=Z[y].Be;Z[y].Nh=function(a){
        a&&this.ea();this.Cb()
        };Z[y].doOnLoad=Z[y].Nh;Z[y].hh=function(a){
        this.qd[t](a)
        };Z[y].addServiceChangedCallback=Z[y].hh;Z[y].bh=function(a){
        this.Lc[t](a)
        };Z[y].addGaiaChangedCallback=Z[y].bh;Z[y].$g=function(a){
        this.xc[t](a)
        };Z[y].addCanConnectCallback=Z[y].$g;Z[y].Ki=function(){
        return this.Wc
        };Z[y].isGaiaUser=Z[y].Ki;
    Z[y].Fk=function(){
        this.tc(this.r+"autoshare?action_link_start=1&root_url="+ca(this.r),{
            height:660,
            width:1E3
        })
        };Z[y].upgradeToGoogleAccount=Z[y].Fk;Z[y].Gk=function(a,b){
        this.Wc=a;this.Xg();b&&b()
        };Z[y].upgradeToGoogleAccountDone=Z[y].Gk;Z[y].oi=function(){
        return this.L
        };Z[y].getServiceInfo=Z[y].oi;
    Z[y].Ac=function(a,b){
        this.Wc||X(this.r+"autoshare?action_ajax_stats_ping=1&stat=connect_no_google&service="+a,{
            method:"GET",
            onComplete:function(){}
            });for(var c in this.xc)if(!this.xc[c](this,a,b))return;X(this.r+"autoshare?action_ajax_stats_ping=1&stat=connect_has_google&service="+a,{
            method:"GET",
            onComplete:function(){}
            });if(a=="facebook")this.Wd(b);else{
            this.tc(this.r+"autoshare?action_popup_auth=1&service="+a+"&connect_only="+(b?"True":"False")+"&root_url="+ca(this.r),{
                height:430,
                width:860
            });a==
            "buzz"&&sh("autoshare-info-box",g)
            }
        };Z[y].connectService=Z[y].Ac;Z[y].Ni=function(a){
        X(this.r+"autoshare?action_ajax_stats_ping=1&stat=launch_facebook_onboarding",{
            method:"GET",
            onComplete:function(){}
            });this.Wd(!a,g)
        };Z[y].launchFacebookOnboarding=Z[y].Ni;
    Z[y].Ch=function(a,b,c){
        var d=!!c;c=J(function(k){
            if(d)Qa(l[Lc],k[Mc]);else{
                this.L=k;this.ea();this.Cb()
                }b&&b()
            },this);var e=J(function(){
            b&&b();this.ea()
            },this),f=d?"display_hybrid_onboarding":"ajax_connect_service",i={};i["action_"+f]=1;i.return_url=a;X(this.r+"autoshare?"+f,{
            postBody:Lg(i)+"&"+this.rb,
            onComplete:c,
            onException:e,
            json:g
        })
        };Z[y].connectServiceDone=Z[y].Ch;Z[y].Kh=function(a){
        a=="facebook"?this.Ug():this.Ud(a)
        };Z[y].disconnectService=Z[y].Kh;
    Z[y].Rj=function(a,b){
        var c=J(function(f){
            this.L=f;this.ea();this.Cb()
            },this),d=J(function(){
            this.ea()
            },this),e={};e.action_ajax_set_connect_only=1;e.service=a;e.connect_only=b?"True":"False";X(this.r+"autoshare?ajax_set_connect_only",{
            postBody:Lg(e)+"&"+this.rb,
            onComplete:c,
            onException:d,
            json:g
        })
        };Z[y].setConnectOnly=Z[y].Rj;
    Z[y].Ud=function(a){
        var b=function(e){
            this.L=e;this.ea();this.Cb()
            }.bind(this),c=function(){
            this.ea()
            }.bind(this),d={};d.action_ajax_disconnect_service=1;d.service=a;X(this.r+"autoshare?ajax_disconnect_service",{
            postBody:Lg(d)+"&"+this.rb,
            onComplete:b,
            onException:c,
            json:g
        })
        };Z[y]._disconnectService=Z[y].Ud;H=Z[y];H.Xg=function(){
        for(var a in this.Lc)this.Lc[a](this)
            };H.ea=function(){
        for(var a in this.qd)this.qd[a](this)
            };
    H.Cb=function(){
        for(var a in this.L){
            var b=this.L[a];a=="facebook"&&b.is_connected&&this.Vg()
            }
        };H.tc=function(a,b){
        if(this.cc)try{
            this.cc[Hc]()
            }catch(c){
            this.cc=h
            }this.cc=dm(a,b)
        };
    H.Wd=function(a,b){
        var c=!!a,d=!!b;this.Vc=g;var e=this.Sh,f=ca(this.r+"autoshare?action_popup_end=1&service=facebook&connect_only="+(c?"True":"False")+"&hybrid_onboarding="+(d?"True":"False")),i=ca(this.r+"autoshare?action_popup_end=1&service=facebook&cancel=1"),k="read_stream,offline_access";c||(k=[k,"publish_stream"][F](","));if(d)k=[k,"email"][F](",");this.tc("http://www.facebook.com/login.php?return_session=1&nochrome=1&fbconnect=1&extern=1&connect_display=popup&api_key="+e+"&v=1.0&next="+f+
            "&cancel_url="+i+"&req_perms="+ca(k)+"&locale="+this.Qi,{
                height:535,
                width:530,
                location:"yes",
                Xk:"yes"
            })
        };H.Ug=function(){
        var a=J(function(c){
            if(c[Sc]){
                c=Ch(c);this.Vd(Dh(c,"html_content"),"disconnect")
                }
            },this);this.Vc=g;var b={};b.action_ajax_facebook_get_disconnect_url=1;X(this.r+"autoshare?ajax_facebook_get_disconnect_url",{
            postBody:Lg(b)+"&"+this.rb,
            onComplete:a
        })
        };
    H.Vg=function(){
        var a=J(function(c){
            if(c[Sc]){
                c=Ch(c);this.Vd(Dh(c,"html_content"),"get_permissions_url_and_info")
                }
            },this),b={};b.action_ajax_facebook_get_info_url=1;b.facebook_critical=this.Vc?"True":"False";X(this.r+"autoshare?ajax_facebook_get_info_url",{
            postBody:Lg(b)+"&"+this.rb,
            onComplete:a
        })
        };
    H.Vd=function(a,b){
        var c=P("autoshare-facebook-connect");if(!c){
            c=sf("DIV");c[Ub]("id","autoshare-facebook-connect");c[Ub]("style","display:none;");m[Ic][r](c)
            }var d=P("autoshare-facebook-connect-iframe");d||(d=sf("IFRAME"));d[Ub]("id","autoshare-facebook-connect-iframe");d[Ub]("scrolling","no");d[Ub]("frameborder","0");d[Ub]("allowTransparency","true");d[Ub]("width","1");d[Ub]("height","1");d[Ub]("style","border: none;");d[Ub]("src","http://"+this.Dk+"/ytfb_connect.html?xsrf="+this.Pj+"&base_url="+
            this.r+"&tpmethod="+b+"&"+a);c[r](d)
        };H.Wg=function(a,b,c,d,e){
        this.L.facebook.is_connected=a;this.L.facebook.connected_as=b;this.L.facebook.has_publish=c;this.L.facebook.has_feed=d;this.L.facebook.has_offline=e;this.ea()
        };Z[y]._facebookUpdateServiceInfo=Z[y].Wg;Z[y].Kk=function(){
        this.Ac("facebook",!this.L.facebook.is_autosharing)
        };var $=ud("yt.timing")||{};I("yt.timing",$,void 0);$.Pi=0;$.Se=0;$.db=function(a){
        var b=$.timer||{};b[a]=Jd();$.timer=b
        };
    $.fc=function(a,b){
        var c=a||S("TIMING_ACTION"),d=$.timer||{},e=d.start,f="",i=[],k="",s="",z="";delete d.start;if($.pt)f="&srt="+$.pt;for(var O in d)i[t](O+"."+n[ib](d[O]-e));d.vr&&d.gv&&i[t]("vl."+n[ib](d.vr-d.gv));if(!d.aft&&d.vr&&d.cl)d.cl>d.vr?i[t]("aft."+n[ib](d.cl-e)):i[t]("aft."+n[ib](d.vr-e));else if(!d.aft&&d.vr)i[t]("aft."+n[ib](d.vr-e));else d.aft||i[t]("aft."+n[ib](d.ol-e));if($.experiment)s="&e="+$.experiment;if($.addomain){
            z=$.addomain;z=z[A](".");if(z[x]>1)z="&ad="+z[0]
                }$.timer={};
        if($.fmt)k+="&fmt="+$.fmt;if($.asv)k+="&asv="+$.asv;if($.plid)k+="&plid="+$.plid;if($.sprot)k+="&sprot="+$.sprot;if($.fv)k+="&fv="+$.fv;if($.manu)k+="&manu="+$.manu;if($.cookieName)k+="&vid="+Vg($.cookieName);if(b)for(var G in b)k+="&"+G+"="+b[G];ui(["http://csi.gstatic.com/csi?v=2&s=youtube&action=",c,f,k,"&rt=",i[F](","),s,z][F](""))
        };
    $.dd=function(){
        var a=S("TIMING_ACTION"),b=$.timer||{};if(a&&b.start)if($.wff&&a[w]("ajax")!=-1&&b.vr&&b.cl)$.fc();else if($.wff&&a[w]("ajax")==-1&&b.vr)$.fc();else if(!$.wff&&(b.ol||b.aft))$.fc()
            };$.Fe=function(){
        $.db("ol");$.dd()
        };$.Ai=function(a){
        var b=++$.Pi;typeof a!="undefined"&&a<4&&$.Se++;$.Se==4&&$.db("tn_c4");b!=1&&b!=5&&b!=10&&b!=20&&b!=30||$.db("tn"+b)
        };var em=function(){
        this.ta={}
        };Kd(em,Ci);wd(em);H=em[y];H.ua="carousel";H.Va=function(){
        this.M("click",this.wh,"num");this.M("click",this.xh,"prev");this.M("click",this.vh,"next")
        };H.wh=function(a){
        if(a){
            var b=this.ba(a);a=ia(this[ub](a,"carousel-num"),10);if(na(a)||a<0)a=0;this.pd(b,a)
            }
        };H.vh=function(a){
        a&&this.Lj(this.ba(a))
        };H.xh=function(a){
        a&&this.Mj(this.ba(a))
        };H.Mj=function(a){
        if(a){
            var b=ia(this[ub](a,"carousel-current"),10);if(na(b)||b<0)b=0;this.pd(a,b-1<0?0:b-1)
            }
        };
    H.Lj=function(a){
        if(a){
            var b=ia(this[ub](a,"carousel-current"),10);if(na(b)||b<0)b=0;var c=ia(this[ub](a,"carousel-slides"),10);if(na(c)||c<0)c=0;c=c-1;this.pd(a,b+1>c?c:b+1)
            }
        };H.pd=function(a,b){
        if(a){
            var c=this.ii(a),d=this.b("num-current"),e;K(c,function(i){
                e=this[ub](i,"carousel-num")==b;ge(i,d,e);ge(i,"yt-uix-pager-selected",e)
                },this);if(c=this.qi(a)){
                var f=lg(h,this.b("slide"),c);if(f)va(c[C],b*f[pb]*-1+"px")
                    }this[mc](a,"carousel-current",b+"")
            }
        };H.ii=function(a){
        return R(h,this.b("num"),a)
        };
    H.qi=function(a){
        return lg(h,this.b("slides"),a)
        };var fm=function(){
        this.ta={}
        };Kd(fm,Ci);wd(fm);H=fm[y];H.ua="hovercard";H.Va=function(){
        this.M("mouseover",this.gd,"target");this.M("mouseout",this.fd,"target")
        };H.gd=function(a){
        var b=J(this.fk,this,a);b=Zf(b,625);this[mc](a,"hovercard-timer",b[oc]());if(a.alt){
            this[mc](a,"hovercard-alt",a.alt);a.alt=""
            }if(a[qc]){
            this[mc](a,"hovercard-title",a[qc]);La(a,"")
            }
        };
    H.fd=function(a){
        var b=ia(this[ub](a,"hovercard-timer"),10);ag(b);this.Ei(a);if(b=this[ub](a,"hovercard-alt"))a.alt=b;if(b=this[ub](a,"hovercard-title"))La(a,b)
            };
    H.fk=function(a){
        var b=this.ba(a);if(b){
            var c=this.b("card"),d=c+Fd(b),e=P(d);if(!e){
                var f=this.Kb(b);if(f){
                    b=wh(a);b.y+=a[md]/2;e=m[Lb]("div");e.id=d;q(e,c);va(e[C],b.x+"px");e[C].top=b.y+"px";d=m[Lb]("div");q(d,this.b("card-border"));var i=m[Lb]("div");q(i,this.b("card-border-arrow"));c=m[Lb]("div");q(c,this.b("card-body"));var k=m[Lb]("div");q(k,this.b("card-body-arrow"));var s=m[Lb]("div");q(s,this.b("card-content"));o(s,f[ob]);c[r](s);d[r](k);d[r](c);e[r](i);e[r](d);m[Ic][r](e);var z=this.b("card-visible");
                    Zf(function(){
                        L(e,z)
                        },10);i=of(l);d=qf(m);if(f=e[pb]+10>b.x){
                        b.x+=a[pb];va(e[C],b.x+"px");L(e,this.b("card-flip"))
                        }if(a=(a=e[md]+b.y>i[kd]+d.y)&&b.y-e[md]>d.y){
                        b.y-=e[md];e[C].top=b.y+"px";L(e,this.b("card-reverse"))
                        }if(this.Xc){
                        a=e[Yb](g);a.id=e.id+"ie";L(a,this.b("card-ie"));if(d=lg("div",this.b("card-body"),a)){
                            o(d,"");qa(d[C],c[pb]+"px");Ya(d[C],c[md]+"px")
                            }m[Ic][xb](a,e);if(c=a.filters["DXImageTransform.Microsoft.Blur"]){
                            c.Enabled=g;if(!f)va(a[C],b.x-c[Gc]+"px");a[C].top=b.y-c[Gc]+"px"
                            }
                        }
                    }
                }
            }
        };
    H.Ei=function(a){
        if(a=this.ba(a)){
            a=this.b("card")+Fd(a);var b=P(a);b&&m[Ic][Kc](b);(a=P(a+"ie"))&&m[Ic][Kc](a)
            }
        };H.Kb=function(a){
        return lg(h,this.b("content"),a)
        };var gm=function(){
        this.ta={}
        };Kd(gm,Ci);wd(gm);H=gm[y];H.ua="overlay";H.Va=function(){
        this.M("click",this.ek,"target");this.M("click",this.He,"close")
        };
    H.ek=function(a){
        var b=this.ba(a);if(b){
            var c=this.b("fg");a=P(c);if(!a){
                var d=this.Kb(b);if(d){
                    a=m[Lb]("div");a.id=c;q(a,c);var e=m[Lb]("div");q(e,this.b("fg-content"));var f=this.b("bg");c=m[Lb]("div");c.id=f;q(c,f);Ya(c[C],pf(l)+"px");b=m[Lb]("iframe");b.id=f+"mask";b.frameBorder="0";b.src='javascript:""';q(b,f);o(e,d[ob]);d=R("iframe",h,e);K(d,function(i){
                        i.src=this[ub](i,"src")||i.src
                        },this);a[r](e);m[Ic][r](b);m[Ic][r](c);m[Ic][r](a);a[C].marginLeft=a[pb]/-2+"px";a[C].marginTop=a[md]/-2+"px";
                    if(this.Xc){
                        d=m[Lb]("div");d.id=a.id+"ie";q(d,a[sc]);L(d,this.b("fg-ie"));qa(d[C],a[pb]+"px");Ya(d[C],a[md]+"px");m[Ic][xb](d,a);if(e=d.filters["DXImageTransform.Microsoft.Blur"]){
                            e.Enabled=g;d[C].marginLeft=a[pb]/-2-e[Gc]+"px";d[C].marginTop=a[md]/-2-e[Gc]+"px"
                            }
                        }a=J(this.He,this);U(c,"click",a);(c=b[ec]&&b[ec][wc])&&U(c,"click",a)
                    }
                }
            }
        };H.He=function(){
        var a=this.b("fg"),b=this.b("bg"),c=P(a);if(c){
            W(c);m[Ic][Kc](c)
            }(a=P(a+"ie"))&&m[Ic][Kc](a);(a=P(b))&&m[Ic][Kc](a);(b=P(b+"mask"))&&m[Ic][Kc](b)
        };
    H.Kb=function(a){
        return lg(h,this.b("content"),a)
        };var hm=j,im=function(){
        ql("init")
        },jm=function(){
        ql("dispose")
        };var km=function(a,b,c){
        if(c=c?P(c):P("messages")){
            o(R("DIV","yt-alert-content",b)[0],a);c[r](b);M(c,"hidden")
            }
        },lm=function(a,b){
        var c=P("error-template")[Yb](g);km(a,c,b)
        },mm=function(a,b){
        var c=P("success-template")[Yb](g);km(a,c,b)
        },nm=function(a){
        if(a=a?P(a):P("messages")){
            L(a,"hidden");o(a,"")
            }
        },om=function(a){
        var b=[];if(a=a?P(a):P("items")){
            a[gc]("INPUT");K(a[gc]("INPUT"),function(c){
                c[Zb]=="checkbox"&&c[uc]&&b[t](c[v])
                })
            }return b
        };I("yt.www.account.getSelectedItems",om,void 0);
    I("yt.www.account.applySort",function(a){
        var b=new gi(l[B]),c=b.ya("sf"),d=b.ya("sa");d=!d||d==0?j:g;b.cb("sf",a);var e=g;if(c==a)e=!d;e?b.cb("sa",1):b.cb("sa",0);cm(b[oc]())
        },void 0);I("yt.www.account.applyPage",function(a){
        var b=new gi(l[B]);b.cb("pi",a);cm(b[oc]())
        },void 0);I("yt.www.account.applySearch",function(a){
        var b=new gi(l[B]);b.cb("sq",a);cm(b[oc]())
        },void 0);I("yt.www.account.applyDisplayMode",function(a){
        var b=new gi(l[B]);b.cb("dm",a);cm(b[oc]())
        },void 0);
    var pm=function(a){
        if(a=a?P(a):P("items")){
            a[gc]("INPUT");K(a[gc]("INPUT"),function(b){
                if(b[Zb]=="checkbox")Ra(b,g)
                    })
            }
        },qm=function(a){
        if(a=a?P(a):P("items")){
            a[gc]("INPUT");K(a[gc]("INPUT"),function(b){
                if(b[Zb]=="checkbox")Ra(b,j)
                    })
            }
        },rm=function(a,b,c){
        a=P(a);if(N(a,b)){
            M(a,b);L(a,c)
            }
        },sm=function(a){
        if(a=P(a)){
            N(a,"yt-button")&&rm(a,"yt-button","yt-button-disabled");N(a,"yt-button-alt")&&rm(a,"yt-button-alt","yt-button-alt-disabled");N(a,"yt-button-compact")&&rm(a,"yt-button-compact","yt-button-compact-disabled")
            }
        };
    I("yt.www.account.isButtonEnabled",function(a){
        a=P(a);return N(a,"yt-uix-button")||N(a,"yt-button")||N(a,"yt-button-alt")||N(a,"yt-button-compact")
        },void 0);var um=function(){
        tm("TransportError")
        };I("yt.www.account.onKeyDownHandler",function(a,b,c){
        var d;if(l[rd])d=a[Nb];else if(a.which)d=a.which;c(d,b)
        },void 0);
    var tm=function(a){
        a=a||T("ERROR_OCCURRED");lm(a);vm()
        },xm=function(){
        wm();M(P("button-addto"),"expanded");M(P("menu-addto"),"hidden");var a=[P("dialog-addto-playlist"),P("dialog-addto-favorites"),P("dialog-addto-quicklist"),P("dialog-addingto-playlist")];K(a,function(b){
            L(b,"hidden")
            });sm("button-addto-playlist");o(P("addto-playlist-checklist"),'<span class="yt-loader">'+T("LOADING_PLAYLISTS")+"</span>");nm("messages-addto-playlist")
        };I("yt.www.account.closeAddToDropdown",xm,void 0);
    var wm=function(){
        Ra(P("all-items-checkbox"),j);qm("videos")
        },ym=function(){
        Ra(P("all-items-checkbox"),g);pm("videos")
        },vm=function(){
        zm();xm()
        },zm=function(){
        wm();M(P("button-new"),"expanded");M(P("menu-new"),"hidden");var a=[P("dialog-new-playlist"),P("dialog-creating-playlist")];K(a,function(b){
            L(b,"hidden")
            });Am()
        };I("yt.www.account.closeNewDropdown",zm,void 0);
    var Am=function(){
        var a=P("new-playlist-title-textbox");if(a)p(a,"");nm("messages-new-playlist")
        },Bm=function(){
        lm(T("NO_VIDEOS_SELECTED"))
        },Cm=function(){
        lm(T("MULTIPLE_VIDEOS_SELECTED"))
        },Dm=function(){
        var a=P("dialog-addto-favorites");L(P("button-addto"),"expanded");L(P("menu-addto"),"hidden");M(a,"hidden");a=[P("dialog-addto-playlist"),P("dialog-addto-quicklist")];K(a,function(b){
            L(b,"hidden")
            })
        };
    I("yt.www.account.toggleVideoDetails",function(a){
        var b=P("video-details-"+a);if(N(b,"hidden")){
            b=P("video-"+a);L(b,"expanded");b=P("video-details-"+a);M(b,"hidden")
            }else{
            b=P("video-"+a);M(b,"expanded");b=P("video-details-"+a);L(b,"hidden")
            }xh("video-thumb-tiny-"+a)
        },void 0);I("yt.www.account.onPlayVideos",function(a){
        vm();nm();Va(m[B],a)
        },void 0);I("yt.www.account.extractVideoSetIds",function(a){
        var b=[];K(a,function(c){
            b[t](c[A](":")[0])
            });return b
        },void 0);
    I("yt.www.account.saveUserPrefState",function(){
        var a=lk.c();a.tb(Y.Td,P("playlist-details")[C][id]!="none");a[Dc]()
        },void 0);I("yt.www.account.onEditVideos",function(a){
        var b=S("RETURN_URL")||ca("/my_videos");vm();nm();if(a[x]==0)Bm();else a[x]>1?Cm():cm("/my_videos_edit?ns=1&video_id="+a[0]+"&next="+b[oc]())
            },void 0);I("yt.www.account.onInsightVideos",function(a){
        vm();nm();if(a[x]==0)Bm();else a[x]>1?Cm():cm("/my_videos_insight?v="+a[0])
            },void 0);
    I("yt.www.account.onAnnotateVideos",function(a){
        a[x]>1?Cm():cm("/my_videos_annotate?v="+a[0])
        },void 0);I("yt.www.account.updateScr",function(){
        var a=P("scr");if(a)p(a,"h="+ea[kd]+"&w="+ea[hb]+"&d="+ea.colorDepth)
            },void 0);var Fm=function(a){
        var b=a[Vb]["new-playlist-title-textbox"][v][u](/\"/g,"'");a=a[Vb].token[v];var c={};c.action_create_playlist=1;c.n=b;c.session_token=a;b=Lg(c);X("/playlist_ajax",{
            postBody:b,
            onComplete:function(d){
                d=fi(d[mb]);var e=d.errors;if(e[x]>0){
                    d=e.pop();lm(d,"messages-new-playlist");Em()
                    }else{
                    d={
                        id:d.response.playlistId,
                        name:d.response.playlistName
                        };mm(T("PLAYLIST_CREATED")+' <a href="/my_playlists?p='+d.id+'">'+Ee(d[cc])+"</a>");zm();Va(m[B],"/my_playlists?p="+d.id+"&ex=1")
                    }
                },
            onError:um,
            json:g
        })
        };I("yt.www.account.my.playlists.onNewPlaylistFormSubmitted",function(a){
        nm("messages-new-playlist");if(a[Vb]["new-playlist-title-textbox"][v]=="")lm(T("MUST_SPECIFY_TITLE"),"messages-new-playlist");else{
            Gm();Fm(a)
            }
        },void 0);
    var Gm=function(){
        L(P("button-new"),"expanded");L(P("menu-new"),"hidden");M(P("dialog-creating-playlist"),"hidden");var a=[P("dialog-new-playlist")];K(a,function(b){
            L(b,"hidden")
            })
        },Em=function(){
        L(P("button-new"),"expanded");L(P("menu-new"),"hidden");M(P("dialog-new-playlist"),"hidden");var a=[P("dialog-creating-playlist")];K(a,function(b){
            L(b,"hidden")
            })
        };I("yt.www.account.my.playlists.showNewPlaylistDialog",Em,void 0);
    var Hm=function(){
        var a=P("dialog-addto-playlist");L(P("button-addto"),"expanded");L(P("menu-addto"),"hidden");M(a,"hidden");a=Lg({
            action_list_playlists_by_current_user:1
        });X("/playlist_ajax",{
            postBody:a,
            onComplete:function(b){
                b=fi(b[mb]);var c=b.errors;if(c[x]>0){
                    for(b=0;b<c[x];b++)lm(c[b],"messages-addto-playlist");Hm()
                    }else{
                    c=b.response.playlists;o(P("addto-playlist-checklist"),"");for(b=0;b<c[x];b++){
                        var d=c[b];P("addto-playlist-checklist").innerHTML+='<div><input type="checkbox" value="'+d.playlistId+
                        '" />'+Ee(d.playlistName)+"</div>"
                        }if(b=P("button-addto-playlist")){
                        N(b,"yt-button-disabled")&&rm(b,"yt-button-disabled","yt-button");N(b,"yt-button-alt-disabled")&&rm(b,"yt-button-alt-disabled","yt-button-alt");N(b,"yt-button-compact-disabled")&&rm(b,"yt-button-compact-disabled","yt-button-compact")
                        }
                    }
                },
            onError:function(){
                lm(T("ERROR_OCCURRED"),"messages-addto-playlist");Hm()
                },
            json:g
        })
        };I("yt.www.account.my.playlists.showAddToPlaylistDialog",Hm,void 0);
    var Im=function(a,b){
        var c={};c.action_add_videos_to_playlists=1;c.v=a[F](",");c.p=b[F](",");c.session_token=Fh("playlist_ajax");c=Lg(c);X("/playlist_ajax",{
            postBody:c,
            onComplete:function(d){
                d=fi(d[mb]).errors;if(d[x]>0){
                    d=d.pop();lm(d,"messages-addto-playlist");Hm()
                    }else{
                    if(S("reloadOnCompletion"))Qa(m,m[B][Zc]);mm(T("VIDEOS_ADDED_TO_PLAYLISTS"));xm()
                    }
                },
            onError:um,
            json:g
        })
        };
    I("yt.www.account.my.playlists.onAddToPlaylistFormSubmitted",function(){
        var a=om("addto-playlist-checklist"),b=om("videos");nm("messages-addto-playlist");if(a[x]==0)lm(T("MUST_SELECT_PLAYLIST"),"messages-addto-playlist");else{
            var c=[];K(b,function(d){
                c[t](d[A](":")[1])
                });Jm();Im(c,a)
            }
        },void 0);
    var Jm=function(){
        L(P("button-new"),"expanded");L(P("menu-new"),"hidden");M(P("dialog-addingto-playlist"),"hidden");var a=[P("dialog-addto-playlist"),P("dialog-addto-favorites"),P("dialog-addto-quicklist")];K(a,function(b){
            L(b,"hidden")
            })
        };I("yt.www.account.my.playlists.addVideoToCurrentPlaylist",function(a){
        Im([a],[S("currentPlaylistId")]);Xf("reloadOnCompletion",g);Jm()
        },void 0);I("yt.www.account.my.playlists.onDeletePlaylist",function(a){
        la(T("ARE_YOU_SURE_DELETE"))&&Km(a)
        },void 0);
    var Km=function(a){
        var b={};b.action_delete_playlist=1;b.p=a;b.session_token=Fh("playlist_ajax");a=Lg(b);X("/playlist_ajax",{
            postBody:a,
            onComplete:function(c){
                c=fi(c[mb]).errors;if(c[x]>0)tm(c.pop());else{
                    nm();mm(T("PLAYLIST_DELETED_SUCCESS"));cm("/my_playlists")
                    }
                },
            onError:um,
            json:g
        })
        },Lm=function(a){
        nm();for(var b=0;b<a[x];b++)lm(a[b])
            };
    I("yt.www.account.my.playlists.toggleShowRecommendations",function(a,b){
        if(a){
            if(S("fetchRecos")){
                Xf("fetchRecos",j);X("/my_playlists?a=playlist_rec_show&action_recommend=1&p="+b,{
                    method:"GET",
                    update:"playlist_recs"
                })
                }V("playlist_recs")
            }else W("playlist_recs")
            },void 0);I("yt.www.account.my.playlists.startEditingPosition",function(a){
        if(!S("isEditingPosition")){
            xh("pos-view-"+a,"pos-edit-"+a);P("pos-edit-"+a)[Kb]()
            }Xf("isEditingPosition",g)
        },void 0);
    I("yt.www.account.my.playlists.finishEditingPosition",function(a,b,c){
        var d=ia(P("pos-view-"+b)[ob],10);c=ia(c,10);var e=ia(S("videoListTotal"),10);if(c>e)c=e;if(c<1)c=1;if(d!=c){
            xh("pos-edit-"+b,"pos-load-"+b);Mm(a,b,d,c)
            }else{
            xh("pos-edit-"+b,"pos-view-"+b);Xf("isEditingPosition",j)
            }
        },void 0);
    var Mm=function(a,b,c,d){
        c=new gi(l[B]);var e={};e.action_reorder_playlist_video=1;e.p=a;e.v=b;e.i=d;e.pi=c.ya("pi")||0;e.ps=c.ya("ps")||S("DEFAULT_NUM_RESULTS");e.sf=c.ya("sf");e.sa=td(c.ya("sa"))?1:0;e.sh=S("sortHeadings")=="True"?1:0;e.dm=c.ya("dm")||0;e.session_token=Fh("playlist_ajax");a=Lg(e);X("/playlist_ajax",{
            postBody:a,
            onComplete:function(){
                nm("messages-edit-playlist");Xf("isEditingPosition",j)
                },
            update:"view-drop",
            onError:um
        })
        };
    I("yt.www.account.my.playlists.removeVideosFromPlaylist",function(a,b){
        var c={};c.action_remove_videos_from_playlist=1;c.p=a;c.v=b[F](",");c.session_token=Fh("playlist_ajax");c=Lg(c);X("/playlist_ajax",{
            postBody:c,
            onComplete:function(d){
                d=fi(d[mb]).errors;d[x]>0?tm(d.pop()):l[B][Ec]()
                },
            onError:um,
            json:g
        })
        },void 0);
    I("yt.www.account.my.playlists.showEditPlaylistThumbnail",function(a){
        if(P("edit-playlist-thumbnail-panel")[C][id]=="none"){
            p(P("edit-playlist-thumbnail-page"),"0");xh(P("edit-playlist-thumbnail-panel"));Nm(a,0,S("PLAYLIST_THUMBNAIL_PAGESIZE"))
            }
        },void 0);
    var Nm=function(a,b,c){
        o(P("edit-playlist-thumbnail-drop"),'<img src="http://s.ytimg.com/yt/img/loader-vfl35975.gif" />');var d={};d.action_list_videos_for_playlist=1;d.p=a;d.pi=b;d.ps=c;d.session_token=Fh("playlist_ajax");b=Lg(d);X("/playlist_ajax",{
            postBody:b,
            onComplete:function(e){
                e=fi(e[mb]);var f=e.errors;if(f[x]>0){
                    nm("messages-edit-playlist");for(e=0;e<f[x];e++)lm(f[e],"messages-edit-playlist")
                        }else{
                    nm("messages-edit-playlist");f=e.response.videos;var i=P("edit-playlist-thumbnail-drop");o(i,"");var k=S("stillImageTemplate");
                    for(e=0;e<f[x];e++)i.innerHTML+='<a class="edit-playlist-thumbnail" href="#" onClick="yt.www.account.my.playlists.setPlaylistThumbnail(this, \''+a+"', '"+f[e].encrypted_set_video_id+"', '"+f[e].encrypted_id+'\'); return false"><img src="'+k[u]("%videoId%",f[e].encrypted_id)+'" /></a>'
                        }
                },
            onError:um,
            json:g
        })
        },Om=function(a,b,c){
        var d={};d.action_set_playlist_thumbnail=1;d.p=a;d.v=b;d.session_token=Fh("playlist_ajax");b=Lg(d);X("/playlist_ajax",{
            postBody:b,
            onComplete:function(e){
                e=fi(e[mb]).errors;if(e[x]>
                    0)Lm(e);else{
                    e={
                        Vk:a,
                        Hk:c
                    };nm("messages-edit-playlist");mm(T("PLAYLIST_THUMBNAIL_UPDATED"),"messages-edit-playlist");xh("edit-playlist-thumbnail-panel");var f=S("stillImageTemplate");P("playlist-thumbnail-img").src=f[u]("%videoId%",e.Hk)
                    }
                },
            onError:um,
            json:g
        })
        };I("yt.www.account.my.playlists.onApplyPlaylistThumbnail",function(a){
        var b=P("edit-playlist-thumbnail-id");if(b[v]!=""){
            b=b[v][A](":");Om(a,b[0],b[1])
            }
        },void 0);
    I("yt.www.account.my.playlists.setPlaylistThumbnail",function(a,b,c,d){
        b=P("edit-playlist-thumbnail-drop")[gc]("A");K(b,function(e){
            M(e,"selected")
            });L(a,"selected");p(P("edit-playlist-thumbnail-id"),[c,d][F](":"))
        },void 0);I("yt.www.account.my.playlists.nextPlaylistThumbnailPage",function(a){
        var b=P("edit-playlist-thumbnail-page");if(b){
            var c=ia(b[v],10);p(b,(c+1)[oc]());Nm(a,c+1,S("PLAYLIST_THUMBNAIL_PAGESIZE"))
            }
        },void 0);
    I("yt.www.account.my.playlists.prevPlaylistThumbnailPage",function(a){
        var b=P("edit-playlist-thumbnail-page");if(b){
            var c=ia(b[v],10);if(c>0){
                p(b,(c-1)[oc]());Nm(a,c-1,S("PLAYLIST_THUMBNAIL_PAGESIZE"))
                }
            }
        },void 0);I("yt.www.account.my.playlists.onUpdatePlaylist",function(a,b,c,d,e,f,i,k){
        nm("messages-edit-playlist");Pm(a,b,c,d,e,f,i,k)
        },void 0);
    var Pm=function(a,b,c,d,e,f,i,k){
        var s={};s.action_edit_playlist=1;s.p=a;s.t=b;s.d=c;s.k=d;s.y=e?0:1;s.e=f?1:0;s.v=i?1:0;s.s=k?1:0;s.session_token=Fh("playlist_ajax");a=Lg(s);X("/playlist_ajax",{
            postBody:a,
            onComplete:function(z){
                z=fi(z[mb]).errors;if(z[x]>0)Lm(z);else{
                    nm("messages-edit-playlist");mm(T("PLAYLIST_EDITED_SUCCESS"),"messages-edit-playlist");l[B][Ec]()
                    }
                },
            onError:um,
            json:g
        })
        };
    I("yt.www.account.my.playlists.onSharePlaylist",function(a){
        l[db]("/share?p="+a,"Share","toolbar=no,width=546,height=485,status=no,resizable=yes,fullscreen=no,scrollbars=no")[Kb]()
        },void 0);I("yt.www.account.my.quicklist.onAddVideosToQuicklist",function(a){
        vm();nm();if(a[x]==0)Bm();else{
            ym();Qm();var b=[];K(a,function(c){
                b[t](c[A](":")[1])
                });Rm(b)
            }
        },void 0);
    var Qm=function(){
        var a=P("dialog-addto-quicklist");L(P("button-addto"),"expanded");L(P("menu-addto"),"hidden");M(a,"hidden");a=[P("dialog-addto-playlist"),P("dialog-addto-favorites")];K(a,function(b){
            L(b,"hidden")
            })
        },Rm=function(a){
        var b={};b.action_add_videos_to_quicklist=1;b.v=a[F](",");b.session_token=Fh("video_ajax");a=Lg(b);X("/video_ajax",{
            postBody:a,
            onComplete:function(c){
                c=fi(c[mb]).errors;if(c[x]>0)tm(c.pop());else{
                    mm(T("VIDEOS_ADDED_TO_QUICKLIST"));xm()
                    }
                },
            onError:um,
            json:g
        })
        };
    I("yt.www.account.my.quicklist.onRemoveVideosFromQuicklist",function(a){
        nm();var b={};b.action_remove_from_queue_json=1;b.v=a[F](",");b.session_token=Fh("watch_queue_ajax");a=Lg(b);X("/watch_queue_ajax",{
            postBody:a,
            onComplete:function(){
                l[B][Ec]()
                },
            onError:um,
            json:g
        })
        },void 0);I("yt.www.account.my.favorites.onDeleteFavorites",function(a){
        vm();nm();if(a[x]==0)Bm();else if(la(T("SURE_TO_DELETE_FAVORITES"))){
            mm(T("WAIT_DELETING_FAVORITES"));Sm(a)
            }
        },void 0);var Sm=function(a){
        var b={};b.action_remove_videos_from_favorites=1;b.v=a[F](",");b.session_token=Fh("video_ajax");a=Lg(b);X("/video_ajax",{
            postBody:a,
            onComplete:function(c){
                c=fi(c[mb]).errors;if(c[x]>0)tm(c.pop());else{
                    mm(T("FAVORITES_REMOVED"));l[B][Ec]()
                    }
                },
            onError:um,
            json:g
        })
        };
    I("yt.www.account.my.favorites.onAddVideosToFavorites",function(a){
        vm();nm();if(a[x]==0)Bm();else{
            ym();Dm();var b=[];K(a,function(c){
                b[t](c[A](":")[1])
                });Tm(b)
            }
        },void 0);var Tm=function(a){
        var b={};b.action_add_videos_to_favorites=1;b.v=a[F](",");b.session_token=Fh("video_ajax");a=Lg(b);X("/video_ajax",{
            postBody:a,
            onComplete:function(c){
                c=fi(c[mb]).errors;if(c[x]>0)tm(c.pop());else{
                    mm(T("VIDEOS_ADDED_TO_FAVES"));xm()
                    }
                },
            onError:um,
            json:g
        })
        };I("yt.www.account.my.favorites.addVideosToFavorites",Tm,void 0);var Um=function(a,b,c,d,e){
        l.google_ad_client=a;l.google_ad_channel=b;l.google_max_num_ads=c;l.google_ad_output="js";l.google_ad_type="text";l.google_only_pyv_ads=g;if(d){
            l.google_kw=d;l.google_kw_type="broad"
            }if(l.dclk_language)l.google_language=l.dclk_language;l.google_ad_request_done=e;m[Bb]('<script language="JavaScript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"><\/script>')
        },Vm=function(){
        if(l.dclk_language)l.google_language=l.dclk_language;l.google_ad_client="pub-6219811747049371";
        l.google_ad_channel="1802068507";l.google_ad_format="300x250_as";l.google_ad_type="text_image";l.google_ad_width=300;l.google_ad_height=250;l.google_alternate_color="FFFFFF";l.google_color_border="FFFFFF";l.google_color_bg="FFFFFF";l.google_color_link="0033CC";l.google_color_text="444444";l.google_color_url="0033CC";m[Bb]('<script language="JavaScript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"><\/script>')
        },Xm=function(){
        if(!l.ppv_fallback_rendered){
            Wm();W("pyv-placeholder");V(l.ppv_fallback_placeholder_id||
                "ppv-placeholder");l.ppv_fallback_rendered=g
            }
        },Wm=function(){
        W(l.pyv_google_ad_collapse_id||"ad_creative_2")
        },Ym=function(a,b,c,d,e){
        var f=Xd(b.media_template_data,function(i){
            return!!i.imageUrl
            });if(!f)return j;a={
            video_id:f.videoId,
            ad_type:a,
            headline:Ge(b.line1),
            image_url:f.imageUrl,
            description1:Ge(b.line2),
            description2:Ge(b.line3),
            channel_title:f.channelName,
            test_mode:(!!e)[oc](),
            destination_url:Ge(b.url)
            };X("/pyv?"+Lg(a),{
            method:"GET",
            update:c,
            onComplete:d
        })
        },$m=function(){
        W("ad_creative_2");
        S("PYV_IS_ALLOWED")?Um("ca-youtube-homepage",S("PYV_AD_CHANNEL")||"",1,S("PYV_KW")||"",Zm):Xm()
        },Zm=function(a){
        var b=P("pyv-placeholder");a[x]==0||!b?Xm():Ym("homepage",a[0],b,function(){
            Wm()
            })
        },bn=function(){
        if(S("PYV_IS_ALLOWED")){
            var a="pyvOnBrowse";if(S("PYV_CATEGORY"))a+=" pyvBrowse_"+S("PYV_CATEGORY");Um("ca-youtube-browse",a,1,"",an)
            }else Vm()
            },an=function(a){
        var b=P("pyv-placeholder");a[x]==0||!b?Vm():Ym("browse",a[0],b,function(){
            W("ad_creative_1")
            })
        },cn=function(a,b){
        var c=P(a);if(c){
            c=
            R("li","video-list-item",c);K(c,function(d,e){
                var f=R("a",h,d);K(f,function(i){
                    var k=i[Qc]("href");if(k&&ba(k)[Fb](/\/watch(\?|#!)v=/))i.href+=b?"&pvpos="+e:"&pvnpos="+e
                        })
                })
            }
        };var dn=function(a,b){
        var c;try{
            c=typeof a[Jc]=="number"
            }catch(d){
            c=j
            }if(c){
            a.selectionStart=b;a.selectionEnd=b
            }else if(Ue){
            c=b;if(a[Zb]=="textarea")c=a[v][$c](0,c)[u](/(\r\n|\r|\n)/g,"\n")[x];b=c;c=a.createTextRange();c.collapse(g);c.move("character",b);c[Pb]()
            }
        };var en=function(a,b,c,d,e,f,i,k){
        var s,z=c[yc];if(z){
            var O=z[ed]=="HTML"||z[ed]=="BODY";if(!O||dh(z,"position")!="static"){
                s=hh(z);O||(s=je(s,new ie(z[Uc],z[nc])))
                }
            }z=hh(a);O=lh(a);z=new Yg(z.x,z.y,O[hb],O[kd]);(O=jh(a))&&z.Ji(new Yg(O[Ab],O.top,O[qd]-O[Ab],O[Wc]-O.top));O=jf(a);var G=jf(c);if(O.o!=G.o){
            var Q=O.o[Ic];G=G.Oc();var ga=new ie(0,0),Da=hf(Q)?hf(Q).parentWindow||hf(Q)[bc]:l,Yc=Q;do{
                var Za;if(Da==G)Za=hh(Yc);else{
                    var Jb=Yc;Za=new ie;if(Jb[kb]==1)if(Jb[bb]){
                        var Hd=fh(Jb);Za.x=Hd[Ab];Za.y=
                        Hd.top
                        }else{
                        Hd=jf(Jb).Lb();Jb=hh(Jb);Za.x=Jb.x-Hd.x;Za.y=Jb.y-Hd.y
                        }else{
                        Za.x=Jb[hc];Za.y=Jb[ic]
                        }Za=Za
                    }Za=Za;ga.x+=Za.x;ga.y+=Za.y
                }while(Da&&Da!=G&&(Yc=Da.frameElement)&&(Da=Da[Lc]));G=ga;G=je(G,hh(Q));if(Ue&&!O.Pb())G=je(G,O.Lb());z.left+=G.x;z.top+=G.y
            }a=(b&4&&ih(a)?b^2:b)&-5;b=new ie(a&2?z[Ab]+z[hb]:z[Ab],a&1?z.top+z[kd]:z.top);if(s)b=je(b,s);if(e){
            b.x+=(a&2?-1:1)*e.x;b.y+=(a&1?-1:1)*e.y
            }var Ea;if(i)if((Ea=jh(c))&&s){
            Ea.top=n.max(0,Ea.top-s.y);Ea.right-=s.x;Ea.bottom-=s.y;va(Ea,n.max(0,Ea[Ab]-s.x))
            }a:{
            e=
            b;s=Ea;e=e.C();Ea=0;a=(d&4&&ih(c)?d^2:d)&-5;d=lh(c);k=k?k.C():d;if(f||a!=0){
                if(a&2)e.x-=k[hb]+(f?f[qd]:0);else if(f)e.x+=f[Ab];if(a&1)e.y-=k[kd]+(f?f[Wc]:0);else if(f)e.y+=f.top
                    }if(i){
                if(s){
                    f=e;Ea=0;if(f.x<s[Ab]&&i&1){
                        f.x=s[Ab];Ea|=1
                        }if(f.x<s[Ab]&&f.x+k[hb]>s[qd]&&i&16){
                        k.width-=f.x+k[hb]-s[qd];Ea|=4
                        }if(f.x+k[hb]>s[qd]&&i&1){
                        f.x=n.max(s[qd]-k[hb],s[Ab]);Ea|=1
                        }if(i&2)Ea|=(f.x<s[Ab]?16:0)|(f.x+k[hb]>s[qd]?32:0);if(f.y<s.top&&i&4){
                        f.y=s.top;Ea|=2
                        }if(f.y>=s.top&&f.y+k[kd]>s[Wc]&&i&32){
                        k.height-=f.y+k[kd]-
                        s[Wc];Ea|=8
                        }if(f.y+k[kd]>s[Wc]&&i&4){
                        f.y=n.max(s[Wc]-k[kd],s.top);Ea|=2
                        }if(i&8)Ea|=(f.y<s.top?64:0)|(f.y+k[kd]>s[Wc]?128:0);i=Ea
                    }else i=256;Ea=i;if(Ea&496){
                    c=Ea;break a
                }
                }e=e;f=Ve&&(Oe||Ze)&&ff("1.9");if(e instanceof ie){
                i=e.x;e=e.y
                }else{
                i=e;e=void 0
                }va(c[C],typeof i=="number"?(f?n[ib](i):i)+"px":i);c[C].top=typeof e=="number"?(f?n[ib](e):e)+"px":e;(d==k?g:!d||!k?j:d[hb]==k[hb]&&d[kd]==k[kd])||kh(c,k);c=Ea
            }return c
        };var fn=h,gn=function(){
        if(P("watch-comments-sigin")){
            Va(l[B],P("watch-comments-sigin")[Zc]);return j
            }return g
        },jn=function(a){
        var b=Ef(a,"FORM");if(b){
            L(b,"input-focused");if(!N(b,"input-expanded"))p(a,"");M(b,"input-collapsed");L(b,"input-expanded");V("comments-attach-video")
            }U(a,"input",hn);U(a,"propertychange",hn)
        },hn=function(a){
        kn(a[Mc])
        },kn=function(a){
        var b=a[E];a=R(h,"comments-post-count-textbox",b)[0];var c=R(h,"comments-post-count",b)[0],d=R(h,"comments-textarea",b)[0];b=R(h,"watch-comments-post",
            b)[0];d=500-d[v][x];p(a,n.max(d,0));if(d<0){
            Ra(b,g);L(c,"error")
            }else{
            Ra(b,j);M(c,"error")
            }
        },ln=1,nn=function(a){
        V("comments-loading");var b=P("comments-view"),c={
            method:"GET",
            onComplete:function(f){
                if(f=Dh(f[Sc],"html_content")){
                    o(b,f);b.scrollIntoView()
                    }W("comments-loading");mn();gk()
                }
            };ln=a;a=S("VIDEO_ID");var d=S("COMMENTS_THRESHHOLD"),e=S("COMMENTS_FILTER");mg(b,"type","everything");X("/watch_ajax?v="+a+"&action_get_comments=1&p="+ln+"&commentthreshold="+d+"&commentfilter="+e+"&commenttype=everything&page_size=10&last_comment_id=",
            c)
        },on=function(a){
        mn();fn=a;var b=P("comments-view"),c=R(h,"content",fn)[0];c=c?N(c,"hide-comment"):g;if(!(ng(a,"pending")=="1"||c&&(ng(a,"removed")=="True"||ng(a,"flagged")=="True"))){
            ng(a,"author-viewing")=="True"||ng(b,"owner-viewing")=="True"?V("watch-comment-remove-link"):W("watch-comment-remove-link");if(ng(b,"owner-viewing")=="True")if(ng(a,"blocked")=="True"){
                W("watch-comment-block-user");V("watch-comment-unblock-user")
                }else{
                V("watch-comment-block-user");W("watch-comment-unblock-user")
                }else{
                W("watch-comment-block-user");
                W("watch-comment-unblock-user")
                }if(ng(b,"disallow-ratings")=="True"){
                W("watch-comment-vote-up");W("watch-comment-vote-down")
                }else{
                V("watch-comment-vote-up");V("watch-comment-vote-down")
                }b=P("comments-actions");M(b,"voted-up");M(b,"voted-down");if(ng(a,"voted")=="1")L(b,"voted-up");else ng(a,"voted")=="-1"&&L(b,"voted-down");M(b,"replying");(c=lg(h,"comments-reply-form",a))&&c[ob]&&L(b,"replying");en(a,2,b,2);L(a,"current")
            }
        },mn=function(){
        var a=P("comments-actions");a[C].top="-1000px";va(a[C],"-1000px");
        fn&&M(fn,"current")
        },pn=function(a,b){
        if(la(T(b?"BLOCK_USER":"UNBLOCK_USER")))X("/link_servlet",{
            postBody:(b?"":"un")+"block_user=1&"+S("BLOCK_USER_XSRF")+"&friend_username="+a
            })
        },qn=function(){
        var a=P("captcha_div");if(a){
            var b=a[E];b[Kc](a);V(b.comment)
            }
        };var rn=function(a){
        M(a,"QLIconImg");M(a,"QLIconImgOver");L(a,"QLIconImgDone");a[sb]();W(a);V(lg("span","quicklist-inlist",a[E]))
        },tn=function(){
        var a=Yk();if(a)o(P(a.id+"-count"),sn()[x])
            },yn=function(a,b,c,d,e,f,i){
        if(un(b)){
            if(a=Yk()){
                a=P(a.id+"-body");b=Ud(sn(),b);var k=R("li","edit-list-item",a)[b];Ia(a,k[jd]);L(k,"video-list-item-highlight");Zf(function(){
                    M(k,"video-list-item-highlight")
                    },500)
                }
            }else{
            vn(b,i);i?wn(1):wn(2);tn();xn();a&&rn(a);f&&vi(f)
            }
        },wn=function(a){
        if(S("HAS_ACTIVE_QUICKLIST")){
            var b=
            P("watch-next-list");b&&!N(b,"yt-uix-expander-collapsed")&&Vk(b,a)
            }else if(b=P("watch-passive-QL")){
            V(b);if(N(b,"yt-uix-expander-collapsed")){
                mg(b,"loaded","false");M(b,"yt-uix-expander-collapsed");Wk(b,a)
                }else Vk(b,a)
                }
        },sn=function(){
        var a=Vg("watch_queue_new");if(a)return a[A](",");return[]
        },zn=function(a){
        a=ce(a,0,100);(a=a[F](","))?Ug("watch_queue_new",a):Wg("watch_queue_new")
        },un=function(a){
        return Yd(sn(),a)
        },vn=function(a,b){
        var c=sn();b?de(c,b,0,a):c[t](a);zn(c)
        },An=function(a){
        var b=sn();
        a=Ud(b,a);if(a>=0){
            Td[ld][D](b,a,1)[x]==1;zn(b)
            }return a
        },xn=function(){
        var a=S("VIDEO_ID"),b=sn();a=Ud(b,a);if(a!=-1){
            b="v="+b[(a+1)%b[x]];if(a=S("LIST_PLAY_NEXT_URL")){
                a=a[u](/v=([a-zA-Z0-9_-]{11})/,b);Xf("LIST_PLAY_NEXT_URL",a)
                }if(a=S("LIST_PLAY_NEXT_URL_WITH_SHUFFLE")){
                a=a[u](/v=([a-zA-Z0-9_-]{11})/,b);Xf("LIST_PLAY_NEXT_URL_WITH_SHUFFLE",a)
                }
            }
        };var Bn=function(a,b){
        yn(h,a,j,"","","disco_add_to_queue_end");if(b){
            yg(b);xg(b)
            }
        };var Cn=function(a,b,c,d,e,f,i){
        this.al=a;this.Zk=b;this.tk=this.tk;this.Oh=d;this.Hi=e;this.Lk=f;this.Mk=i;this.Vi="ad_creative_"+a;this.Qh="ad_creative_expand_btn_"+a;this.Ah="ad_creative_collapse_btn_"+a;this.Pk="ad_creative_iframe_"+a;this.$k="ad_creative_"+c;this.Sk="masthead_child_div";this.Nk=Y.Sd;this.ce="HIDDEN_MASTHEAD_ID"
        };
    Na(Cn,{
        collapse:function(){
            W(this.Vi);this.Hi||W(this.Ah);V(this.Qh);var a=lk.c();a.l(this.ce,this.Oh);a[Dc]();vi("homepage_collapse_masthead_ad")
            },
        expand:function(){
            var a=lk.c();a.l(this.ce,j);a[Dc]();vi("homepage_expand_masthead_ad");Va(m[B],m[B][Zc])
            }
        });var Dn=j,En=j;var Fn=function(a,b,c){
        this.Ec=[];this.F=[];this.Y=a;this.Rb=b;this.Oa=c;this.Qb=j;this.Fc=[];this.$c="";pl("init",J(this.oa,this))
        };I("yt.www.home.ModuleHelper",Fn,void 0);Fn[y].gh=function(a){
        a&&this.Ec[t](a)
        };Fn[y].addModule=Fn[y].gh;H=Fn[y];H.oa=function(){
        this.Ij();this.Ba();this.Oa||this.Gi()
        };H.Ij=function(){
        this.F=[];K(this.Ec,function(a){
            P("feedmodule-"+a)&&this.F[t](a)
            },this)
        };
    H.Ba=function(){
        K(this.F,function(a,b,c){
            var d=P("mup-"+a),e=P("mdown-"+a);a=P("mclose-"+a);if(d)b==0||this.Rb||this.Oa?L(d,"disabled"):M(d,"disabled");if(e)b==c[x]-1||this.Rb||this.Oa?L(e,"disabled"):M(e,"disabled");if(a)this.Rb||this.Oa?L(a,"disabled"):M(a,"disabled")
                },this)
        };H.Gi=function(){
        var a=P("feed_undo_delete_link");a&&Vl(a,"click",J(this.Ek,this));K(this.Ec,function(b){
            this.Nb(b)
            },this)
        };
    H.Nb=function(a){
        var b=function(c,d,e,f){
            (d=P(d+c))&&Vl(d,"click",J(e,f,c))
            };b(a,"medit-",this.zf,this);b(a,"mup-",this.Zi,this);b(a,"mdown-",this.Yi,this);b(a,"mclose-",this.Gj,this);P("feedmodule-"+a);switch(a){
            case "SUB":(a=P("homepage-exclude-videos-already-watched"))&&Vl(a,"click",J(this.th,this));break;case "GEO":(a=P("geo-hometown-btn"))&&Vl(a,"click",J(this.Xj,this));break
                }
        };H.zf=function(a){
        a=P(a+"-options");xh(a)
        };H.zh=function(a){
        a=P(a+"-options");sh(a,j)
        };Fn[y].closeOptionsPane=Fn[y].zh;
    H=Fn[y];H.Zi=function(a){
        this.Ue(a,g)
        };H.Yi=function(a){
        this.Ue(a,j)
        };H.Ue=function(a,b){
        if(!this.Ce(a)){
            var c=Ud(this.F,a),d=b?c-1:c+1,e=P("feedmodule-"+a),f=P("feedmodule-"+this.F[d]);if(e&&f){
                var i=this.F[c];this.F[c]=this.F[d];this.F[d]=i;d==this.F[x]-1?this.hf(a,a,"arrow"):this.hf(a,this.F[d+1],"arrow");c=f[dc];e[E][xb](f,e[dc]);f[E][xb](e,c);this.Ba()
                }
            }
        };H.hf=function(a,b,c){
        this.Qb?this.Fc[t]({
            targetModule:a,
            pivotModule:b,
            logging:c
        }):this.jf(a,b,c)
        };
    H.jf=function(a,b,c){
        X("/index_ajax"+(c?"?"+c:""),{
            postBody:["module="+a,"dir=dragdrop","next_module="+b,"session_token="+this.Y][F]("&"),
            onComplete:J(function(){
                if(this.Fc[x]>0){
                    var d=this.Fc[fb]();this.jf(d.targetModule,d.pivotModule,d.logging)
                    }else this.Qb=j
                    },this),
            onException:J(function(){
                this.Qb=j
                },this)
            });this.Qb=g
        };H.Ce=function(a){
        if(this.Rb||this.Oa){
            this.zf(a+"-options");return g
            }return j
        };
    H.Gj=function(a){
        if(!this.Ce(a)){
            X("/index_ajax",{
                postBody:["remove=true","module="+a,"session_token="+this.Y][F]("&")
                });var b=P("feedmodule-"+a);sh(b,j);b.id="UNDO-"+b.id;this.ff();this.Ba();this.$c=a;sh("mundo-remove",g)
            }
        };H.Ek=function(){
        var a=this.$c;X("/index_ajax",{
            postBody:["remove=true&undo=true","module="+a,"session_token="+this.Y][F]("&"),
            onComplete:J(function(){
                this.$c=""
                },this)
            });a="feedmodule-"+a;var b=P("UNDO-"+a);sh(b,g);b.id=a;this.ff();this.Ba();sh("mundo-remove",j)
        };
    H.Zj=function(a,b,c){
        sh(a+"-loading-msg",g);b=P(b);b=b[Oc][b[Oc][rc]][v];if(c=="AGG")b*=4;X("/index_ajax",{
            postBody:["alter=true","module="+a,"num="+b,"session_token="+this.Y][F]("&"),
            onComplete:J(function(d){
                o(P("feedmodule-"+a),d[mb]);this.Nb(a);this.Ba();sh(a+"-options",g);sh(a+"-loading-icn",j);sh(a+"-laoding-msg",j)
                },this)
            })
        };Fn[y].setLengthPreference=Fn[y].Zj;
    Fn[y].Yj=function(a,b){
        sh(a+"-options-AGG",j);sh(a+"-options-SIN",j);sh(a+"-options-BTH",j);sh(a+"-options-"+b,g);sh(a+"-loading-icn",g);sh(a+"-loading-msg",g);X("/index_ajax",{
            postBody:["alter=true","module="+a,"ftype="+b,"session_token="+this.Y][F]("&"),
            onComplete:J(function(c){
                o(P("feedmodule-"+a),c[mb]);this.Nb(a);this.Ba();sh(a+"-options",g);sh(a+"-loading-icn",j);sh(a+"-loading-msg",j)
                },this)
            })
        };Fn[y].setLayoutPreference=Fn[y].Yj;
    Fn[y].Xj=function(){
        var a=["alter=true","module=GEO","loc="+P("geo-hometown")[v],"session_token="+this.Y];X("/index_ajax",{
            postBody:a[F]("&"),
            onComplete:J(function(b){
                o(P("feedmodule-GEO"),b[mb]);this.Nb("GEO");this.Ba()
                },this)
            })
        };Fn[y].uh=function(a,b){
        if(this.Oa)sh("feed-helptext",g);else{
            sh("feed-view-picker",j);sh("feed-view-loading-msg",g);X("/index_ajax?feedview="+b,{
                postBody:["alter=true","module="+a,"session_token="+this.Y][F]("&"),
                onComplete:J(function(c){
                    o(P("feedmodule-"+a),c[mb])
                    },this)
                })
            }
        };
    Fn[y].changeFeedFilter=Fn[y].uh;Fn[y].ff=function(){
        var a=R("DIV","feedmodule-anchor");this.F=[];K(a,function(b){
            b=b.id;b[$c](0,5)!="UNDO-"&&b[$c](b[x]-6,b[x])!="-clone"&&this.F[t](b[A]("-")[1])
            },this)
        };Fn[y].Ti=function(a,b){
        var c="/index_ajax?delete="+b,d=["xfeedvid="+a,"module=ALL","item_type="+b,"session_token="+this.Y],e=P("feedxm-"+a+"-"+b);if(!e)e=P("feedxs-"+a+"-"+b)[E];e&&L(e,"hid");X(c,{
            postBody:d[F]("&"),
            onComplete:J(function(f){
                var i=P("ALL-data");if(i)o(i,f[mb])
                    },this)
            })
        };
    Fn[y].markFeedVideoWatched=Fn[y].Ti;Fn[y].Ui=function(a){
        X("/index_ajax",{
            postBody:["alter=true&module=SUB","seen="+a,"session_token="+this.Y][F]("&"),
            onComplete:J(function(b){
                var c=uf("DIV");o(c,b[mb]);(b=P("feedmodule-SUB"))&&b[E].replaceChild(c[Ob],b)
                },this)
            })
        };Fn[y].markSubscriptionVideoWatched=Fn[y].Ui;Fn[y].th=function(){
        var a=["alter=true","setfilter=True","module=SUB","session_token="+this.Y];P("homepage-exclude-videos-already-watched")[uc]==1&&a[t]("filter=True");X("/index_ajax",{
            postBody:a[F]("&")
            })
        };var Gn=function(){
        this.R=j;this.Ea=h
        };I("yt.www.home.Subscriptions",Gn,void 0);Gn[y].Sj=function(a){
        this.Ea=a
        };Gn[y].setCurrentLink=Gn[y].Sj;Gn[y].si=function(a){
        if(this.Ea)if(!(P("edit-subscription-bubble")||this.R)){
            a=R("A","edit-subscription-recent-activity-link",a);if(a[x]!=0){
                a=a[0];if(this.Ea!=a){
                    this.Ea&&sh(this.Ea,j);sh(a,g);this.Ea=a
                    }
                }
            }
        };Gn[y].handleActivityItemMouseover=Gn[y].si;
    Gn[y].Ak=function(a,b,c,d){
        if(!this.R){
            this.R=g;var e=P("edit-subscription-bubble");if(e){
                wf(e);this.R=j
                }else X("/iyt_ajax?action_get_inline_subscription_edit_markup",{
                postBody:["publisher_id="+c,"publisher_username="+b,"session_token="+d][F]("&"),
                onComplete:J(function(f){
                    f=Dh(f[Sc],"html_content");var i=uf("DIV");o(i,f);a[E][E][xb](i[Ob],a[E][dc]);this.R=j
                    },this),
                onException:J(function(){
                    this.R=j
                    },this)
                })
            }
        };Gn[y].toggleInlineSubscriptionEditBubble=Gn[y].Ak;
    Gn[y].Ci=function(a,b,c){
        if(!this.R){
            var d=P("edit-subscription-all-activity")[uc],e=P("edit-subscription-uploads-only")[uc],f=P("edit-subscription-unsubscribe")[uc],i="";if(d)i="all_activity";else if(e)i="uploads";else if(f)i="unsubscribe";if(i){
                this.R=g;X("/ajax_subscriptions?edit_subscription="+b,{
                    postBody:["username="+a,"subscription_level="+i,"session_token="+c][F]("&"),
                    onComplete:J(function(){
                        var k=P("edit-subscription-bubble");wf(k);i=="unsubscribe"&&this.Ej(a);this.R=j
                        },this),
                    onException:J(function(){
                        this.R=
                        j
                        },this)
                    })
                }
            }
        };Gn[y].handleUpdateClick=Gn[y].Ci;Gn[y].Ej=function(a){
        var b=P("recent-activity-box");a=R("SPAN","username_"+a,b);for(b=0;b<a[x];b++)sh(a[b][E],j)
            };Gn[y].yh=function(){
        var a=P("edit-subscription-bubble");wf(a)
        };Gn[y].closeInlineSubscriptionEditBubble=Gn[y].yh;var Hn=function(a){
        a[mb]=="block"&&function(){
            try{
                for(var b=this;;){
                    if(b[Lc]==b)break;b=b[Lc]
                    }if(b.frameElement!=h)aa("busted")
                    }catch(c){
                m[Bb]("--\><plaintext style=display:none><!--");l[db]("/","_top");Qa(top,"/")
                }
            }()
        };if(l!=l.top){
        var In=m[Tb];Ng(In)||X("/roger_rabbit",{
            postBody:"location="+ca(In)+"&self="+ca(l[B][Zc]),
            onComplete:Hn
        })
        };var Jn=0,Kn=h,Ln=function(a,b,c,d,e){
        this.Wk=c;this.ph=a;this.m=b;this.Pa=b[v];this.H=b[v];this.ad=b[v];this.Fa="";this.Gh=h;this.be=Lj(b);this.X=this.T=this.$a=h;this.Za=-1;this.S=this.g=h;this.Sb=this.bc=0;this.na=h;this.Yc=/^(zh-(CN|TW)|ja|ko)$/[eb](c);this.lc=this.kc=j;this.Hj=e+"?hl="+c+"&ds="+d+"&client=youtube&hjson=t&jsonp=window.yt.www.suggest2.handleResponse";this.m[Ub]("autocomplete","off");U(this.m,"blur",J(this.ej,this));this.m.onkeyup_original=this.m.onkeyup;U(this.m,"keydown",J(this.ij,
            this));U(this.m,"keyup",J(this.jj,this));this.g=uf("table");this.g.id="completeTable_"+Jn++;this.g.cellSpacing=this.g.cellPadding="0";q(this.g,"yt-suggest-table");this.ma();m[Ic][r](this.g);this.S=uf("iframe");this.S.id="yt-suggest-iframe-"+Jn++;q(this.S,"yt-suggest-iframe");m[Ic][r](this.S);this.dc();U(l,"resize",J(this.dc,this));this.Yc&&$f(this.wj,10);this.gc()
        };H=Ln[y];H.ej=function(){
        this.kc||this.ma();this.kc=j
        };H.wj=function(){
        var a=this.m[v];a!=this.Pa&&this.Pc(0);this.Pa=a
        };
    H.qe=function(){
        this.kc=g;this.m[sb]();Zf(J(this.Jb,this),10)
        };H.dc=function(){
        va(this.g[C],Aj(this.m,"offsetLeft")+"px");this.g[C].top=Aj(this.m,"offsetTop")+this.m[md]-1+"px";qa(this.g[C],this.m[pb]+"px");va(this.S[C],this.g[C][Ab]);this.S[C].top=this.g[C].top;qa(this.S[C],this.g[pb]+"px");Ya(this.S[C],this.g[md]+"px")
        };H.ma=function(){
        if(this.na){
            ag(this.na);this.na=h
            }vh(this.g,j);vh(this.S,j)
        };H.Dd=function(){
        vh(this.g,g);vh(this.S,g);this.dc();this.lc=g
        };
    H.uc=function(){
        return this.g[C][lc]=="visible"
        };H.ij=function(a){
        a=a||l[rd];var b=a[Nb];Kn=this;if(b==13&&this.uc()&&this.Fa==this.H&&this.X){
            this.ma();return j
            }if(b==27&&this.uc()){
            this.ma();this.hc(this.H);Ca(a,g);Ua(a,j);return j
            }if(!Gj(b))return g;this.Sb++;this.Sb%3==1&&this.Pc(b);return j
        };H.jj=function(a){
        a=a||l[rd];var b=a[Nb];!(this.Yc&&Gj(b))&&this.Sb==0&&this.Pc(b);this.Sb=0;if(this.H[x]>0&&this.m.onkeyup_original){
            this.m.onkeyup_original(a);ge(this.g,"rtl",this.m.dir=="rtl")
            }return!Gj(b)
        };
    H.Pc=function(a){
        this.Yc&&Gj(a)&&this.qe();if(this.m[v]!=this.Pa||a==39){
            this.H=this.m[v];this.be=Lj(Oi)
            }if(a==40||a==63233)this.gf(this.Za+1);else(a==38||a==63232)&&this.gf(this.Za-1);this.dc();if(this.Fa!=this.H&&!this.na)this.na=Zf(J(this.ma,this),500);this.Pa=this.m[v];this.Pa==""&&!this.$a&&this.gc()
        };H.qe=function(){
        this.kc=g;this.m[sb]();Zf(J(this.Jb,this),10)
        };H.Jb=function(){
        this.m[Kb]()
        };H.gj=function(a){
        this.m[sb]();this.hc(a.completeString);this.ma();this.ph(a.completeString);return j
        };
    H.hc=function(a){
        p(this.m,a);this.Pa=a
        };H.Nj=function(a,b){
        this.bc++;var c=uf("script");nf(c,{
            type:"text/javascript",
            id:b,
            charset:"utf-8",
            src:this.Hj+"&q="+a+"&cp="+this.be
            });var d=P(b),e=m[gc]("head")[0];d&&e[Kc](d);e[r](c)
        };H.gc=function(){
        if(this.ad!=this.H&&this.H){
            this.Nj(ca(this.H),"jsonpACScriptTagY");this.Jb()
            }this.ad=this.H;for(var a=100,b=1;b<=(this.bc-2)/2;++b)a*=2;a+=50;this.$a=Zf(J(this.gc,this),a);return g
        };H.bj=function(){
        this.ma();this.Fa="";this.$a&&ag(this.$a);this.$a=h;return j
        };
    H.xj=function(a){
        for(var b=this.g[bd],c=b[x]-1;c>=0;--c)this.g.deleteRow(c);var d=0;for(c in a){
            var e=a[c];if(e){
                d++;this.lh(e[0],d==1)
                }
            }if(b[x]>0){
            a=this.g[Cb](-1);U(a,"mousedown",J(this.Ze,this));b=uf("td");b.colSpan=2;q(a,"yt-suggest-close");c=uf("span");a[r](b);b[r](c);Uj(c,T("SUGGEST_CLOSE"));U(c,"click",J(this.bj,this))
            }
        };H.Ze=function(a){
        a=a||l[rd];xg(a);this.Dd();this.m[Kb]();return yg(a)
        };
    H.We=function(a){
        if(!this.lc){
            if(this.X)q(this.X,"yt-suggest-unselected");q(a,"yt-suggest-selected");this.X=a;if(this.T)for(a=0;a<this.T[x];a++)if(this.T[a]==this.X){
                this.Za=a;break
            }
            }
        };H.hj=function(a,b){
        var c=b||l[rd];if(this.lc){
            this.lc=j;this.We(a,c)
            }
        };
    H.gf=function(a){
        if(this.Fa==""&&this.H!=""){
            this.ad="";this.gc()
            }else if(!(this.H!=this.Fa||!this.$a))if(!(!this.T||this.T[x]<=0))if(this.uc()){
            var b=this.T[x]-1;if(this.X)q(this.X,"yt-suggest-unselected");if(a==b||a==-1){
                this.Za=-1;this.hc(this.H);this.Jb()
                }else{
                if(a>b)a=0;else if(a<-1)a=b-1;this.Za=a;this.X=this.T[wb](a);q(this.X,"yt-suggest-selected");this.hc(this.X.completeString)
                }
            }else this.Dd()
            };
    H.lh=function(a,b){
        var c=this.g[bd][x];c!=0&&this.g[bd][c-1][sc]=="yt-suggest-close"&&--c;c=this.g[Cb](c);q(c,"yt-suggest-unselected");c.completeString=a;U(c,"click",J(this.gj,this,c));U(c,"mouseover",J(this.We,this,c));U(c,"mousemove",J(this.hj,this,c));U(c,"mousedown",J(this.Ze,this));var d=uf("td");Uj(d,a);q(d,"yt-suggest-left");if(uj&&kj[eb](a))ta(d[C],"2px");var e=uf("td");q(e,"yt-suggest-right");b&&Uj(e,T("SUGGEST_SUGGEST"));if(N(this.g,"rtl")){
            c[r](e);c[r](d)
            }else{
            c[r](d);c[r](e)
            }
        };
    H.xi=function(a){
        this.bc>0&&this.bc--;if(a[0]==this.H){
            if(this.na){
                ag(this.na);this.na=h
                }this.Fa=a[0];this.Gh=a[1];this.xj(a[1]);this.Za=-1;(this.T=this.g[bd])&&this.T[x]>0?this.Dd():this.ma()
            }
        };var Mn=[];var Nn=function(){};Kd(Nn,yi);H=Nn[y];H.he=g;H.ac=h;H.wd=function(a){
        this.ac=a
        };H.addEventListener=function(a,b,c,d){
        Vl(this,a,b,c,d)
        };H.removeEventListener=function(a,b,c,d){
        Xl(this,a,b,c,d)
        };
    H.dispatchEvent=function(a){
        a=a;if(Ad(a))a=new yl(a,this);else if(a instanceof yl)Sa(a,a[Mc]||this);else{
            var b=a;a=new yl(a[Zb],this);te(a,b)
            }b=1;var c,d=a[Zb],e=Sl;if(d in e){
            e=e[d];d=g in e;var f;if(d){
                c=[];for(f=this;f;f=f.ac)c[t](f);f=e[g];f.P=f.h;for(var i=c[x]-1;!a.qa&&i>=0&&f.P;i--){
                    ua(a,c[i]);b&=bm(f,c[i],a[Zb],g,a)&&a.Ya!=j
                    }
                }if(j in e){
                f=e[j];f.P=f.h;if(d)for(i=0;!a.qa&&i<c[x]&&f.P;i++){
                    ua(a,c[i]);b&=bm(f,c[i],a[Zb],j,a)&&a.Ya!=j
                    }else for(c=this;!a.qa&&c&&f.P;c=c.ac){
                    ua(a,c);b&=bm(f,c,a[Zb],
                        j,a)&&a.Ya!=j
                    }
                }a=Boolean(b)
            }else a=g;return a
        };H.u=function(){
        Nn.z.u[D](this);$l(this);this.ac=h
        };var On=sd.window;var Pn=function(a,b,c,d){
        if(!yd(a)||!yd(b))aa(Error("Start and end parameters must be arrays"));if(a[x]!=b[x])aa(Error("Start and end points must be the same length"));this.vb=a;this.Ph=b;this.duration=c;this.Xd=d;Ta(this,[])
        };Kd(Pn,Nn);var Qn={},Rn=h,Sn=function(){
        On.clearTimeout(Rn);var a=Jd();for(var b in Qn)Qn[b].ie(a);Rn=pe(Qn)?h:On[vc](Sn,20)
        },Tn=function(a){
        a=Fd(a);delete Qn[a];if(Rn&&pe(Qn)){
            On.clearTimeout(Rn);Rn=h
            }
        };H=Pn[y];H.w=0;H.se=0;H.G=0;H.startTime=h;H.pe=h;H.Zc=h;
    H.play=function(a){
        if(a||this.w==0){
            this.G=0;Ta(this,this.vb)
            }else if(this.w==1)return j;Tn(this);this.startTime=Jd();if(this.w==-1)this.startTime-=this[zc]*this.G;this.pe=this[gd]+this[zc];this.Zc=this[gd];this.G||this.ob();this.kj();this.w==-1&&this.mj();this.w=1;a=Fd(this);a in Qn||(Qn[a]=this);Rn||(Rn=On[vc](Sn,20));this.ie(this[gd]);return g
        };H.stop=function(a){
        Tn(this);this.w=0;if(a)this.G=1;this.Od(this.G);this.nj();this.Sa()
        };H.u=function(){
        this.w!=0&&this.stop(j);this.dj();Pn.z.u[D](this)
        };
    H.ie=function(a){
        this.G=(a-this[gd])/(this.pe-this[gd]);if(this.G>=1)this.G=1;this.se=1E3/(a-this.Zc);this.Zc=a;Bd(this.Xd)?this.Od(this.Xd(this.G)):this.Od(this.G);if(this.G==1){
            this.w=0;Tn(this);this.fj();this.Sa()
            }else this.w==1&&this.kd()
            };H.Od=function(a){
        Ta(this,new Array(this.vb[x]));for(var b=0;b<this.vb[x];b++)this[Rc][b]=(this.Ph[b]-this.vb[b])*a+this.vb[b]
            };H.kd=function(){
        this.ha("animate")
        };H.ob=function(){
        this.ha("begin")
        };H.dj=function(){
        this.ha("destroy")
        };H.Sa=function(){
        this.ha("end")
        };
    H.fj=function(){
        this.ha("finish")
        };H.kj=function(){
        this.ha("play")
        };H.mj=function(){
        this.ha("resume")
        };H.nj=function(){
        this.ha("stop")
        };H.ha=function(a){
        this.dispatchEvent(new Un(a,this))
        };var Un=function(a,b){
        yl[D](this,a);Ta(this,b[Rc]);this.x=b[Rc][0];this.y=b[Rc][1];this.bl=b[Rc][2];this.duration=b[zc];this.G=b.G;this.Ok=b.se;this.Yk=b.w;this.Yd=b
        };Kd(Un,yl);var Vn=function(a,b,c,d,e){
        Pn[D](this,b,c,d,e);this.element=a
        };Kd(Vn,Pn);Vn[y].mc=vd;Vn[y].kd=function(){
        this.mc();Vn.z.kd[D](this)
        };Vn[y].Sa=function(){
        this.mc();Vn.z.Sa[D](this)
        };Vn[y].ob=function(){
        this.mc();Vn.z.ob[D](this)
        };var Wn=function(a,b,c,d,e){
        if(typeof b=="number")b=[b];if(typeof c=="number")c=[c];Vn[D](this,a,b,c,d,e);if(b[x]!=1||c[x]!=1)aa(Error("Start and end points must be 1D"))
            };Kd(Wn,Vn);
    Wn[y].mc=function(){
        var a=this[Rc][0],b=this[fd][C];if("opacity"in b)b.opacity=a;else if("MozOpacity"in b)b.MozOpacity=a;else if("filter"in b)b.filter=a===""?"":"alpha(opacity="+a*100+")"
            };Wn[y].show=function(){
        Xa(this[fd][C],"")
        };Wn[y].jb=function(){
        Xa(this[fd][C],"none")
        };var Xn=function(a,b,c){
        Wn[D](this,a,1,0,b,c)
        };Kd(Xn,Wn);Xn[y].ob=function(){
        this.show();Xn.z.ob[D](this)
        };Xn[y].Sa=function(){
        this.jb();Xn.z.Sa[D](this)
        };var Yn=function(a){
        this.Di=a
        };Kd(Yn,yi);var Zn=new Dl(0,100);H=Yn[y];H.bd=function(a,b,c,d,e){
        if(yd(b))for(var f=0;f<b[x];f++)this.bd(a,b[f],c,d,e);else this.Aj(Vl(a,b,c||this,d||j,e||this.Di||this));return this
        };H.Aj=function(a){
        if(this.f)this.f[a]=g;else if(this.pa){
            this.f=Zn.Ka();this.f[this.pa]=g;this.pa=h;this.f[a]=g
            }else this.pa=a
            };H.df=function(){
        if(this.f){
            for(var a in this.f){
                Yl(a);delete this.f[a]
            }Zn.Wa(this.f);this.f=h
            }else this.pa&&Yl(this.pa)
            };H.u=function(){
        Yn.z.u[D](this);this.df()
        };
    H.handleEvent=function(){
        aa(Error("EventHandler.handleEvent not implemented"))
        };var $n=function(){};wd($n);$n[y].aj=0;$n[y].hi=function(){
        return":"+(this.aj++)[oc](36)
        };$n.c();var bo=function(a){
        this.Ha=a||jf();this.Jj=ao
        };Kd(bo,Nn);bo[y].Fi=$n.c();var ao=h;H=bo[y];H.Mb=h;H.Ha=h;H.Na=j;H.Z=h;H.Jj=h;H.Xi=h;H.J=h;H.fa=h;H.Db=h;H.Ef=j;H.di=function(){
        return this.Mb||(this.Mb=this.Fi.hi())
        };H.la=function(){
        return this.Z
        };H.we=function(){
        return this.La||(this.La=new Yn(this))
        };H.ak=function(a){
        if(this==a)aa(Error("Unable to set parent component"));if(a&&this.J&&this.Mb&&this.J.te(this.Mb)&&this.J!=a)aa(Error("Unable to set parent component"));this.J=a;bo.z.wd[D](this,a)
        };
    H.wd=function(a){
        if(this.J&&this.J!=a)aa(Error("Method not supported"));bo.z.wd[D](this,a)
        };H.aa=function(){
        return this.Ha
        };H.Fb=function(){
        this.Z=this.Ha[Lb]("div")
        };H.Jh=function(a){
        if(this.Na)aa(Error("Component already rendered"));else if(a){
            this.Ef=g;if(!this.Ha||this.Ha.o!=hf(a))this.Ha=jf(a);this.Hb(a);this.Ib()
            }else aa(Error("Invalid element to decorate"))
            };H.Hb=function(a){
        this.Z=a
        };H.Ib=function(){
        this.Na=g;this.Jc(function(a){
            !a.Na&&a.la()&&a.Ib()
            })
        };
    H.Ic=function(){
        this.Jc(function(a){
            a.Na&&a.Ic()
            });this.La&&this.La.df();this.Na=j
        };H.u=function(){
        bo.z.u[D](this);this.Na&&this.Ic();if(this.La){
            this.La.Ga();delete this.La
            }this.Jc(function(a){
            a.Ga()
            });!this.Ef&&this.Z&&wf(this.Z);this.J=this.Xi=this.Z=this.Db=this.fa=h
        };H.Kb=function(){
        return this.Z
        };H.te=function(a){
        return this.Db&&a?qe(this.Db,a)||h:h
        };H.Jc=function(a,b){
        this.fa&&K(this.fa,a,b)
        };
    H.removeChild=function(a,b){
        if(a){
            var c=Ad(a)?a:a.di();a=this.te(c);if(c&&a){
                var d=this.Db;c in d&&delete d[c];Zd(this.fa,a);if(b){
                    a.Ic();a.Z&&wf(a.Z)
                    }a.ak(h)
                }
            }if(!a)aa(Error("Child is not in parent component"));return a
        };var co=function(a,b){
        var c=a?jf(a):b;bo[D](this,c);this.oj=a||this.aa().o[Ic];this.$b={}
        };Kd(co,bo);co[y].od=g;co[y].gb=j;var eo=["position","top","left","width","cssFloat"],fo=["position","top","left","display","cssFloat","marginTop","marginLeft","marginRight","marginBottom"];H=co[y];H.Fb=function(){
        co.z.Fb[D](this);this.Hb(this.la())
        };H.Hb=function(a){
        co.z.Hb[D](this,a);L(a,"goog-scrollfloater")
        };
    H.Ib=function(){
        co.z.Ib[D](this);if(!this.Aa)this.Aa=this.aa().Fb("div",{
            style:"visibility:hidden"
        });var a=this.la();this.Xe=hh(a).y;this.dk(this.od);this.we().bd(l,"scroll",this.Pd);this.we().bd(l,"resize",this.wi)
        };H.u=function(){
        co.z.u[D](this);delete this.Aa
        };H.dk=function(a){
        if(this.od=a){
            this.mh();this.Pd()
            }else this.Gd()
            };H.Pd=function(){
        if(this.od){
            this.aa().o;this.aa().Lb().y>this.Xe?this.pk():this.Gd()
            }
        };
    H.pk=function(){
        if(!this.gb){
            var a=this.la();this.aa().o;var b=hh(a).x,c=qh(a)[hb];this.$b={};le(eo,function(d){
                this.$b[d]=a[C][d]
                },this);le(fo,function(d){
                this.Aa[C][d]=a[C][d]||ch(a,d)||bh(a,d)
                },this);kh(this.Aa,a[pb],a[md]);$g(a,{
                left:b+"px",
                width:c+"px",
                cssFloat:"none"
            });a[E].replaceChild(this.Aa,a);this.oj[r](a);if(this.jd()){
                Ma(a[C],"absolute");a[C].setExpression("top",'document.compatMode=="CSS1Compat"?documentElement.scrollTop:document.body.scrollTop')
                }else{
                Ma(a[C],"fixed");a[C].top="0"
                }this.gb=
            g
            }
        };H.Gd=function(){
        if(this.gb){
            var a=this.la();for(var b in this.$b)a[C][b]=this.$b[b];this.jd()&&a[C].removeExpression("top");this.Aa[E].replaceChild(a,this.Aa);this.gb=j
            }
        };H.wi=function(){
        this.Gd();var a=this.la();this.Xe=hh(a).y;this.Pd()
        };H.jd=function(){
        return Ue&&!(ff("7")&&this.aa().Pb())
        };H.mh=function(){
        if(this.jd()){
            var a=this.aa().o;a=eh(a);if(a[Xc].backgroundImage=="none"){
                Wa(a[C],this.aa().Oc()[B].protocol=="https:"?"url(https:///)":"url(about:blank)");a[C].backgroundAttachment="fixed"
                }
            }
        };var go=function(){
        this.a=P;this.da=R;this.console=l[ad];this.Ye=j
        };go[y].oa=function(){
        this.qc=l;U(this.qc,"load",J(this.Oi,this))
        };go[y].init=go[y].oa;H=go[y];
    H.Oi=function(){
        var a=this.a("vm-playlist-copy-to");if(a)Ra(a,g);var b=this.a("vm-playlist-remove-videos");if(b)Ra(b,g);this.ef();U(a,"click",J(this.zk,this));a=this.a("vm-playlist-search-field");U(a,"click",J(this.Ge,this));U(a,"blur",J(this.Ge,this));U(a,"keyup",J(this.zi,this));U(this.a("vm-videos-copyto-cancel"),"click",J(this.Zb,this));U(this.a("vm-playlist-copy-to-submit"),"click",J(this.ti,this));U(this.a("vm-new-playlist"),"click",J(this.Ck,this));U(this.a("vm-new-playlist-save"),"click",
            J(this.cj,this));U(this.a("vm-new-playlist-cancel"),"click",J(this.ld,this));U(this.a("vm-video-select-all"),"click",J(this.Kj,this));U(this.a("vm-playlist-video-list-ol"),"click",J(this.Lh,this));this.re=new co;this.re.Jh(this.a("vm-video-actions-bar"));U(l,"scroll",J(this.yi,this));U(this.a("vm-opt-out-link"),"click",J(this.ui,this))
        };H.ui=function(){
        this.ab({
            servlet:"/my_videosmanager_beta",
            postData:{
                opt_out:g
            },
            onComplete:function(){
                l[B][Ec]()
                }
            })
        };
    H.yi=function(){
        var a=this.a("vm-floater-shadow");this.re.gb?V(a):W(a)
        };H.Lh=function(a){
        if(N(a[Mc],"video-checkbox"))this.Kd();else{
            var b=Ef(a[Mc],"button");b&&N(b,"vm-playlist-edit-video")&&this.Bj(a)
            }
        };H.Kj=function(a){
        var b=this.da("input","video-checkbox"),c=a[Mc][uc]?g:j;K(b,function(d){
            Oa(d,c)
            },this);this.Kd()
        };
    H.zi=function(){
        var a=ve(this.a("vm-playlist-search-field")[v]);if(this.Ye){
            var b=this.da("span","vm-playlist-copyto-title",this.a("vm-videos-copyto-dialog"));K(b,function(c){
                var d;if(Ue&&"innerText"in c)d=c.innerText[u](/(\r\n|\r|\n)/g,"\n");else{
                    d=[];Cf(c,d,g);d=d[F]("")
                    }d=d[u](/\xAD/g,"");d=d[u](/ +/g," ");if(d!=" ")d=d[u](/^\s*/,"");d=d;Xa(Ef(c,"li")[C],d[pd]()[w](a[pd]())==-1?"none":"")
                },this)
            }
        };
    H.Ge=function(a){
        var b=this.a("vm-playlist-search-field"),c=T("VM_SEARCH_PLAYLISTS");if(a[Zb]=="click"&&b[v]==c)p(b,"");else if(a[Zb]=="blur"&&b[v]==""){
            p(b,c);b[sb]()
            }
        };H.Kd=function(){
        var a=[this.a("vm-playlist-copy-to"),this.a("vm-playlist-remove-videos"),this.a("vm-playlist-delete-videos")];this.ye()[x]>0?this.lf(a,j):this.lf(a,g)
        };H.lf=function(a,b){
        K(a,function(c){
            if(c)Ra(c,b)
                })
        };H.Ck=function(a){
        var b=this.a("vm-dialog-new-playlist");th(b)?this.ld():this.lk(a)
        };
    H.lk=function(a){
        var b=this.a("vm-dialog-new-playlist");if(b[C][id]=="none"){
            this.a("vm-form-new-playlist").reset();V(b);en(a[Mc],1,b,0);this.a("vm-new-playlist-title-field")[Kb]()
            }this.Je=U(m,"click",J(this.de,this,this.ld,b.id,"vm-new-playlist"))
        };
    H.cj=function(){
        var a=this.a("vm-new-playlist-title-field");if(/^[\s\xa0]*$/[eb](a[v])){
            a[Kb]();this.jc(T("VM_MUST_SPECIFY_TITLE"),"vm-new-playlist-notifs",g)
            }else{
            zf(this.a("vm-new-playlist-save"),T("VM_ADDTO_CREATING"));this.ik(T("VM_PLAYLIST_CREATING"),"vm-new-playlist-notifs",g);this.Eh()
            }
        };
    H.Eh=function(){
        var a=this.a("vm-new-playlist-title-field")[v][u](/\"/g,"'"),b=this.a("vm-new-playlist-desc-field")[v],c=this.a("vm-new-playlist-tags-field")[v];this.ab({
            servlet:"/playlist_ajax",
            postData:{
                action_create_playlist:1,
                n:a,
                d:b,
                k:c
            },
            onComplete:J(this.lj,this)
            })
        };H.lj=function(a){
        a=fi(a[mb]);var b=a.errors;if(b[x]>0)this.Ed(b);else{
            a=a.response.playlistId;Xa(this.a("vm-dialog-new-playlist")[C],"none");a="/my_playlists?p="+a;if((b=S("numPlaylists"))&&b==30)a+="&playlist_msg=1";cm(a)
            }
        };
    H.Bj=function(a){
        a=Ef(a[Mc],"li");a=S("currentPlaylistId")?a.id[A](":")[1]:a.id[u](/^vm-video-/,"");cm("/my_videos_edit?ns=1&video_id="+a+"&next="+(S("RETURN_URL")||ca("/my_videos"))[oc]())
        };H.Fd=function(a,b,c){
        if(c=c?this.a(c):this.a("vm-general-notifs")){
            var d=R("DIV","yt-alert-content",b)[0];zf(d,a);o(c,"");c[r](b);V(b);this.Uk=l[vc](J(function(){
                this.Yd=new Xn(b,750);this.Yd.play()
                },this),8E3)
            }
        };H.jc=function(a,b,c){
        c=this.a(c?"error-small-template":"error-template")[Yb](g);this.Fd(a,c,b)
        };
    H.ik=function(a,b,c){
        c=this.a(c?"info-small-template":"info-template")[Yb](g);this.Fd(a,c,b)
        };H.nk=function(a,b,c){
        c=this.a(c?"success-small-template":"success-template")[Yb](g);this.Fd(a,c,b)
        };H.hk=function(){
        this.jc(T("ERROR_OCCURRED"))
        };H.Ed=function(a){
        K(a,function(b){
            this.jc(b)
            },this)
        };H.ni=function(){
        var a=this.da("input","video-checkbox");return Vd(a,function(b){
            return b[uc]
            })
        };H.ye=function(){
        return Wd(this.ni(),function(a){
            return a[v]
            })
        };H.Rh=function(a){
        return Wd(a,function(b){
            return b[A](":")[1]
            })
        };
    H.mi=function(){
        var a=this.da("input","vm-playlist-copyto-checkbox");return Vd(a,function(b){
            return b[uc]
            })
        };H.li=function(){
        return Wd(this.mi(),function(a){
            return a[v]
            })
        };H.ef=function(){
        var a=this.da("input","video-checkbox");K(a,function(b){
            if(b[uc])Oa(b,j)
                });Oa(this.a("vm-video-select-all"),j)
        };H.zk=function(a){
        var b=this.a("vm-videos-copyto-dialog");th(b)?this.Zb():this.gk(a)
        };
    H.gk=function(a){
        var b=this.a("vm-videos-copyto-dialog");if(b[C][id]=="none"){
            V(b);en(a[Mc],1,b,0);vf(this.a("vm-copyto-list"));this.eh();this.ji();this.Ie=U(m,"click",J(this.de,this,this.Zb,b.id,"vm-playlist-copy-to"))
            }
        };H.de=function(a,b,c,d){
        d=vg(d);var e=Ef(d,h,"vm-dialog");b=e&&e.id==b||d.id==b;e=Ef(d,h,"vm-button");!(e&&e.id==c||d.id==c)&&!b&&a[D](this)
        };H.eh=function(){
        var a=this.a("vm-copyto-list"),b=sf("li",{
            id:"vm-copyto-loading"
        });zf(b,T("VM_LOADING_PLAYLISTS"));a[r](b)
        };H.Fj=function(){
        wf(this.a("vm-copyto-loading"))
        };
    H.ji=function(){
        this.ab({
            servlet:"/playlist_ajax",
            postData:{
                action_list_playlists_by_current_user:1
            },
            onComplete:J(this.yj,this)
            })
        };H.yj=function(a){
        a=fi(a[mb]);var b=a.errors;if(b[x]>0)this.Ed(b);else{
            a=a.response.playlists;this.Ye=g;this.Fj();b=l[B][Nc]=="/my_quicklist";this.Bc("Favorites","FAVORITES",l[B][Nc]=="/my_favorites");this.Bc("Queue","QUEUE",b);var c=S("currentPlaylistId");K(a,function(d){
                var e=j;if(c&&c==d.playlistId)e=g;this.Bc(d.playlistName,d.playlistId,e)
                },this)
            }
        };
    H.Bc=function(a,b,c){
        var d=this.a("vm-playlist-search-template"),e=this.a("vm-copyto-list");d=d[Yb](g);d.id="";Xa(d[C],"");var f=this.da("span","vm-playlist-search-template-title",d)[0];zf(f,a);M(f,"vm-playlist-search-template-title");L(f,"vm-playlist-copyto-title");c&&L(f,"disabled");f.id=b;a=this.da("input","vm-playlist-search-template-checkbox",d)[0];p(a,b);Ra(a,c);M(a,"vm-playlist-search-template-checkbox");L(a,"vm-playlist-copyto-checkbox");L(a,"vm-playlist-copyto-"+b);e[r](d)
        };
    H.ti=function(){
        var a=this.li();if(a[x]==0)this.jc(T("VM_ADDTO_NONE_SELECTED"),h,g);else{
            var b=this.a("vm-playlist-copy-to-submit");Ra(b,g);zf(b,T("VM_ADDTO_ADDING"));b=this.ye();b=S("currentPlaylistId")?this.Rh(b):b;var c=j,d=j,e=j;if(Yd(a,"FAVORITES")){
                Zd(a,"FAVORITES");c=g
                }if(Yd(a,"QUEUE")){
                Zd(a,"QUEUE");d=g
                }if(a[x]>0)e=g;c&&this.ih(b);d&&this.kh(b);e&&this.jh(b,a)
            }
        };
    H.jh=function(a,b){
        this.ab({
            servlet:"/playlist_ajax",
            postData:{
                action_add_videos_to_playlists:1,
                v:a[F](","),
                p:b[F](",")
                },
            onComplete:J(this.md,this,"VM_VIDEOS_ADDED_TO_PLAYLISTS")
            })
        };H.ih=function(a){
        this.ab({
            servlet:"/video_ajax",
            postData:{
                action_add_videos_to_favorites:1,
                v:a[F](",")
                },
            onComplete:J(this.md,this,"VM_VIDEOS_ADDED_TO_FAVORITES")
            })
        };H.kh=function(a){
        this.ab({
            servlet:"/video_ajax",
            postData:{
                action_add_videos_to_quicklist:1,
                v:a[F](",")
                },
            onComplete:J(this.md,this,"VM_VIDEOS_ADDED_TO_QUEUE")
            })
        };
    H.ab=function(a){
        var b=a.servlet,c=a.postData,d=a.noJSON?j:g;c.session_token=Fh(b[A]("/")[1]);c=Lg(c);X(b,{
            postBody:c,
            onComplete:a.onComplete,
            onError:this.hk,
            json:d
        })
        };H.md=function(a,b){
        var c=fi(b[mb]).errors;if(c[x]>0)this.Ed(c);else{
            this.nk(T(a),h,g);this.Zb();this.ef();this.Kd()
            }c=this.a("vm-playlist-copy-to-submit");if(c.disabled){
            Ra(c,j);zf(c,T("VM_ADDTO_ADD_VIDEOS"))
            }
        };
    H.Zb=function(){
        var a=this.a("vm-videos-copyto-dialog");if(a[C][id]!="none"){
            p(this.a("vm-playlist-search-field"),T("VM_SEARCH_PLAYLISTS"));xh(a)
            }this.Ie&&sg(this.Ie)
        };H.ld=function(){
        var a=this.a("vm-dialog-new-playlist");a[C][id]!="none"&&xh(a);this.Je&&sg(this.Je)
        };var io=function(a){
        a=a[u](";dc_seed=",";kmyd=watch-channel-brand-div;dc_seed=");W("instream_google_companion_ad_div");W("instream_gut_companion");W("gut_companion");W("google_companion_ad_div");V("ad300x250");V("watch-channel-brand-div");var b=P("ad300x250"),c=n[ib](n[Pc]()*1E4);o(b,['<iframe src="',a,'" name="ifr_300x250ad',c,'" id="ifr_300x250ad',c,'" width="300" height="250" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no"></iframe>'][F](""));ho()
        },jo=function(a){
        a=
        a[u](";dc_seed=",";kmyd=watch-longform-ad;dc_seed=");W("instream_google_companion_ad_div");W("instream_gut_companion");V("watch-longform-ad");V("watch-longform-text");V("watch-longform-ad-placeholder");var b=P("watch-longform-ad-placeholder"),c=n[ib](n[Pc]()*1E4);o(b,['<iframe src="',a,'" name="ifr_300x60ad',c,'" id="ifr_300x60ad',c,'" width="300" height="60" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no"></iframe>'][F](""));ho()
        },ko=function(a){
        var b=P("watch-longform-ad-placeholder");
        if(a){
            W("instream_google_companion_ad_div");W("instream_gut_companion");V("watch-longform-ad");V("watch-longform-text");V("watch-longform-ad-placeholder");o(b,a)
            }else W("watch-longform-ad");ho()
        },lo=function(a,b){
        var c="watch-channel-brand-div",d="ad300x250",e=300,f=250;if(a=="video"){
            c="watch-longform-ad";d="watch-longform-ad-placeholder";e=300;f=60;W("instream_google_companion_ad_div")
            }var i=ma(b);o(P(d),['<iframe name="fw_ad" id="fw_ad" ','width="'+e+'" height="'+f+'" ','marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no"></iframe>'][F](""));
        var k=P("fw_ad");k=k[ec]?k[ec]:k.contentDocument[wc]?k.contentDocument[wc]:k.contentDocument;e=fa[Bc][pd]();d=e[w]("msie")!=-1;e=e[w]("opera")!=-1;k[wc][db]();k[wc][Bb](i);d||e?Zf(function(){
            k[wc][Hc]()
            },7500):k[wc][Hc]();V(c);ho()
        },mo=function(){
        V("watch-channel-brand-div");W("ad300x250");W("gut_companion");Ya(P("google_companion_ad_div")[C],"250px");ho()
        },no=function(){
        W("watch-longform-ad");ho()
        },oo=function(){
        W("watch-channel-brand-div");ho()
        },ho=function(){
        var a=ud("yt.www.watch.ads.handleAdLoaded");
        a&&a[D]()
        },po=function(){},qo=function(a){
        Xf("POPOUT_AD_SLOTS",a)
        },ro=function(){
        var a=P("watch-longform-popup");Ra(a,g);L(a,"yt-button-disabled")
        },so=function(a){
        var b=P("watch-longform-popup");Ra(b,j);qo(a);M(b,"yt-button-disabled")
        },to=function(a){
        l.google_ad_output="html";if(a){
            l.google_ad_height="60";l.google_ad_format="300x60_as";l.google_container_id="instream_google_companion_ad_div"
            }else{
            l.google_ad_height="250";l.google_ad_format="300x250_as";l.google_container_id="google_companion_ad_div"
            }
        },
    uo=function(a){
        if(a){
            W("watch-longform-ad-placeholder");W("watch-channel-brand-div");W("instream_gut_companion");V("watch-longform-text");V("watch-longform-ad");Ya(P("instream_google_companion_ad_div")[C],"60px");V("instream_google_companion_ad_div")
            }else{
            W("ad300x250");W("watch-longform-ad");W("gut_companion");V("google_companion_ad_div");V("watch-channel-brand-div");Ya(P("google_companion_ad_div")[C],"250px")
            }ho()
        },vo=function(){
        W("instream_google_companion_ad_div");W("watch-longform-text");W("watch-longform-ad-placeholder");
        ho()
        },wo=function(a){
        if(a){
            W("watch-longform-ad-placeholder");W("watch-longform-text");W("instream_google_companion_ad_div");V("watch-longform-text");V("watch-longform-ad");V("instream_gut_companion")
            }else{
            W("ad300x250");W("watch-longform-ad");W("google_companion_ad_div");V("watch-channel-brand-div");V("gut_companion")
            }ho()
        };var xo=["prepage","pagetop","watchsearchclose","contenttop","videoextra","contentbottom","pagebottom","postpage"],yo=j,zo=h,Ao=h,Bo=function(){
        return N(P("page"),"watch-needs-rental")
        },Co=function(){
        var a=l[B][ab];if(a[rb](0)=="#")a=a[rb](1)=="!"?a[kc](2):a[kc](1);return a
        },Eo=function(){
        var a=Kg(l[B][ab]);if(a.q)bl(a.q,a[cb]);else{
            dl();if(a.v==zo)if(!(a.rented&&Bo()))return;Do();var b=m[gc]("head")[0];a=m[Lb]("script");a.src=m[nb]("www-core-js").src;b[r](a);var c=function(){
                if(l.yt){
                    var d=m[Lb]("script");
                    ra(d,"yt.www.watch.ajax.init();");b[r](d)
                    }else l[vc](c,50)
                    };c()
            }
        },Do=function(){
        yo=j;$.timer={};$.db("start");Ao=re($.timer);try{
            jm()
            }catch(a){}tl();var b=ud("yt.pubsub.instance_");b&&b[$b](void 0);ug();for(b=Uf[x]-1;b>=0;b--)ag(Uf[b]);Uf=[];for(b=Vf[x]-1;b>=0;b--)bg(Vf[b]);Vf=[];b=0;for(var c=xo[x];b<c;++b){
            var d=P("watch-"+xo[b]+"-section");L(d,"watch-section-loading")
            }l.scroll(0,0);for(var e in l)if((e in Sf||e[w]("google")==0)&&e!="yt")l[e]=ha;Sf={};l.yt=ha
        },Fo=function(a,b){
        var c=a[w](b)+b[x];
        return a[$c](c,a[w]('"',c))
        },Go=function(){
        var a=Kg(l[B][ab]);if(!a.v&&!a.q)Va(l[B],"/videos");else if(!a.v&&a.q&&!zo)Va(l[B],"/results?search_query="+a.q);else{
            zo=a.v;var b=j,c=function(){
                var f=P("movie_player");if(f&&f.loadVideoByFlashvars){
                    b=g;if((f.src||f.movie||"")[w]("watch_as3")!=-1)try{
                        var i={
                            video_id:a.v,
                            ajax_preroll:"12"
                        },k=[];a.feature&&k[t]("f:"+a.feature);a.NR&&k[t]("n:"+a.NR);if(k[x]!=0)i.sdetail=k[F](",");f.loadVideoByFlashvars(i)
                        }catch(s){}
                        }else Zf(c,50)
                    };a.v&&Zf(c,0);var d=(new Date)[fc]()+
            ia(n[Pc]()*1234567,10),e="/watch?"+Co()+"&ajax=1&nocache="+d;X(e,{
                method:"GET",
                onException:function(){
                    Va(l[B],e)
                    },
                onError:function(){
                    Va(l[B],e)
                    },
                onComplete:function(f){
                    if(Kg(l[B][ab]).v!=a.v)Go();else{
                        var i=f[mb];if(i[w]('id="watch-video-container"')==-1)Va(l[B],e);else{
                            $.db("art");f=Fo(i,'<link id="www-core-css" rel="stylesheet" href="');var k=Fo(i,'<script id="www-core-js" src="'),s=/^http:\/\/.*www-core-vfl\d*\.js$/;if(!/^http:\/\/.*www-core-vfl\d*\.css$/[eb](f)||!s[eb](k))Va(l[B],"/videos");else if(l[B].search[w]("debugjs")==
                                -1&&(f!=P("www-core-css")[Zc]||k!=P("www-core-js").src))l[B][Ec](g);else{
                                K(xo,function(G){
                                    var Q=P("watch-"+G+"-section");o(Q,i[$c](i[w]("<!-- begin "+G+" section --\>"),i[w]("<!-- end "+G+" section --\>")));M(Q,"watch-section-loading")
                                    });i[w]('<html lang="')!=-1&&m[jc][Ub]("lang",Fo(i,'<html lang="'));q(m[Ic],Fo(i,'<body class="'));q(P("page"),Fo(i,'<div id="page" class="'));i[u](/\x3cscript([\s\S]*?)\x3e([\s\S]*?)\x3c\/script/ig,function(G,Q,ga){
                                    G=m[Lb]("script");var Da=Q[Fb](/src="([\S]*?)"/);if(Da){
                                        if(Q[w]('id="www-core-js"')!=
                                            -1)return;G.src=Da[1]
                                        }else ra(G,ga);m[gc]("head")[0][r](G)
                                    });f=m[Lb]("script");ra(f,"yt.www.watch.ajax.initReady();");m[gc]("head")[0][r](f);var z=Bo(),O=function(){
                                    dl();var G=P("movie_player");if(yo&&(z||G&&G.playVideo&&b)){
                                        $.db("cl");if((G.src||G.movie||"")[w]("watch_as3")!=-1)if(a.v&&!z){
                                            G.onPrerollReady("12");G.playVideo()
                                            }try{
                                            im()
                                            }catch(Q){}
                                        }else Zf(O,50)
                                        };Zf(O,0)
                                }
                            }
                        }
                    }
                })
            }
        };var Ho,Io;var Jo=["reportConcernResult1","reportConcernResult2","reportConcernResult3","reportConcernResult4","reportConcernResult5","reportConcernResult6","reportConcernResult7"],Ko=function(a){
        X("/watch_ajax?video_id="+a+"&action_get_flag_video_component=1",{
            method:"GET",
            onComplete:function(){
                o(P("inappropriateMsgsDiv"),P("inappropriateMsgs")[ob]);o(P("inappropriateMsgs"),"");V("inappropriateMsgsDiv");kk()
                },
            update:"inappropriateVidDiv"
        })
        };var Lo=function(a){
        if(S("SHUFFLE_ENABLED")){
            var b=S("LIST_PLAY_NEXT_URL_WITH_SHUFFLE");b+="&shuffle="+S("SHUFFLE_VALUE")
            }else b=S("LIST_PLAY_NEXT_URL");if(b&&S("LIST_AUTO_PLAY_ON")){
            var c=S("LIST_AUTO_PLAY_VALUE");b+=c&&!a?"&playnext="+c:"&playnext=1"
            }if(b){
            cm(b);return j
            }
        };var Mo,No=j,Oo=j,Po="",Qo={},Ro=function(){
        return S("RESUME_COOKIE_NAME")
        },So=function(a,b){
        var c=Ro();if(!c)return h;var d=Vg(c,"")[A](",");d=Vd(d,function(e){
            return 0!=e[w](a)&&e[x]
            });d[x]>=4&&d[fb]();d[t](a+":"+b);Ug(c,d[F](","),1814400)
        },To=function(a){
        var b=Ro();if(!b)return h;var c=Vd(Vg(b,"")[A](","),function(d){
            return 0!=d[w](a)
            });0==c[x]?Wg(b):Ug(b,c[F](","),1814400)
        },Uo=function(a){
        var b=Ro();if(!b)return h;b=Vg(b,"")[A](",");b=Vd(b,function(c){
            return 0==c[w](a)
            });if(0==b[x])return h;b=
        b[0][A](":");if(2!=b[x])return h;return ia(b[1],10)
        },Vo=function(){
        var a=P("movie_player"),b=a.getDuration();a=n[lb](a.getCurrentTime());var c=S("VIDEO_ID");a<=120||a+120>=b?To(c):So(c,n[lb](a))
        },Wo=function(a){
        Oo||(Mo=a)
        },Xo=function(){
        var a=P("movie_player");if(a){
            var b=S("SHOW_NEXT_BUTTON");if(b==g)a.showNextButton();else b==j&&a.hideNextButton()
                }
        },Yo=function(){
        Lo(g)
        },ap=function(a){
        if(S("WATCH5")){
            Zo(a);Dk(a)
            }else $o(a,g)
            },bp=function(a){
        var b=P("watch-next-list-body-collapsed");ge(b,"hover",
            a)
        },$o=function(a,b){
        for(var c=P("baseDiv"),d=S("WIDE_PLAYER_STYLES"),e=0;e<d[x];++e)ge(c,d[e],a);sh("masthead-utility-menulink-short",a);sh("masthead-utility-menulink-long",!a);(c=P("watch-longform-player"))&&c[sb]();if(b){
            Zo(a);gk()
            }
        },Zo=function(a){
        a?Ug("wide","1",-1):Ug("wide","0",-1)
        },cp=function(a,b){
        var c=b!=h?b:g,d=P("movie_player");d.seekTo(a,g);if(c)if(P("watch-video-container"))l.scroll(0,0);else Va(l[B],"#movie_player");d.playVideo()
        },dp=function(){
        var a={
            target:"FullScreenVideo",
            width:ea.availWidth,
            height:ea.availHeight,
            resizable:g,
            fullscreen:g
        };dm("/watch_popup?v="+S("VIDEO_ID"),a)
        },ep=function(a){
        if(S("VIDEO_ID")!=a){
            a={
                v:a
            };if(S("SHUFFLE_ENABLED"))a.shuffle=S("SHUFFLE_VALUE");if(S("LIST_AUTO_PLAY_ON"))a.playnext=S("LIST_AUTO_PLAY_VALUE");var b=Jg(l[B][Zc]);if(b&&b.playnext_from)a.playnext_from=b.playnext_from;cm("/watch",a)
            }
        },gp=function(){
        var a=Kg(l[B][ab]),b=a.t||a.at;if(b){
            Qo.t=a.t;Qo.at=a.at;return fp(b)
            }else return h
            },fp=function(a){
        var b=0;if(a[w]("h")!=-1){
            a=a[A]("h");b=a[0]*60*60;
            a=a[1]
            }if(a[w]("m")!=-1){
            a=a[A]("m");b=a[0]*60+b;a=a[1]
            }if(a[w]("s")!=-1){
            a=a[A]("s");b=a[0]*1+b
            }else b=a*1+b;return b
        },hp=function(a,b,c){
        var d=S("ANALYTICS_ANNOTATIONS_TRACKER");l._gaq[t](function(){
            d._trackEvent(a,b,c)
            })
        },ip=function(){
        Va(l[B],"#watch-main-area")
        },jp=function(a,b,c,d,e,f,i){
        if(b)$.fmt=b;if(c)$.asv=c;if(d)$.plid=d;if(e)$.sprot=e;if(f)$.fv=f;if(i)$.manu=i;b=$.timer||{};c=0;for(d=a[x]/2;c<d;c++)b[a[2*c]]=a[2*c+1];$.dd()
        };var kp=["watch-share-video-div","watch-share-blog-quick","shareMessageQuickDiv","shareVideoEmailDiv"],mp=function(){
        K(kp,W);V("aggregationServicesDiv");lp("fewer-options","more-options");lp("watch-share-services-expanded","watch-share-services-collapsed")
        },np=function(a,b,c,d){
        var e=S("LOCALE")||"en_US",f=P(b);a="video_id="+a;if(c=="all"&&e){
            K(kp,W);V(f);lp("more-options","fewer-options");lp("watch-share-services-collapsed","watch-share-services-expanded");a=a+"&locale="+e+"&action_get_share_video_component=1"
            }else if(c==
            "email"||c=="blog"&&d){
            if(th("watch-share-video-div")){
                lp("more-options","fewer-options");lp("watch-share-services-collapsed","watch-share-services-expanded")
                }K(kp,W);V(f);if(c=="email")a+="&action_get_share_message_component=1";else a=a+"&blog_info_id="+d+"&action_get_share_blog_component=1"
                }V("aggregationServicesDiv");if(th(f))if(f.loaded){
            if(d)if(f.ge!=d){
                c={
                    method:"GET",
                    update:f
                };X("/watch_ajax?"+a,c);f.ge=d
                }
            }else{
            c={
                method:"GET",
                onComplete:function(){
                    f.loaded=g;if(d)f.ge=d
                        },
                onException:function(){
                    W(f)
                    },
                update:f
            };X("/watch_ajax?"+a,c)
            }
        },pp=function(a,b,c,d){
        np(a,b,c);V("aggregationServicesDiv");lp("more-options","fewer-options");lp("watch-share-services-collapsed","watch-share-services-expanded");op("MORE_SHARING_OPTIONS",a,"",d);return j
        },op=function(a,b,c,d){
        Ah("/sharing_services?"+["name="+ca(a),"v="+b,c?"locale="+c:"",d?d:""][F]("&"))
        },lp=function(a,b){
        W(a);V(b)
        };var qp=function(a,b){
        var c=ha;c=b==h?S("XSRF_TOKEN"):b;var d=m[Lb]("input");d[Ub]("name",S("XSRF_FIELD_NAME"));d[Ub]("type","hidden");d[Ub]("value",c);a[r](d)
        },rp=[];var sp=function(a){
        if(a){
            a="http://www.youtube.com/watch?v="+S("VIDEO_ID")+"&layer_token="+a;var b=P("iv_invite_link");if(b){
                p(b,a);Ra(b,j)
                }if(b=P("iv_invite_reset"))Ra(b,j);if(b=P("iv_mailto_link")){
                var c=[],d=0;c[d++]="mailto:";c[d++]="someone@example.com";c[d++]="?";c[d++]="&subject=";c[d++]=ca(T("ANNOTATIONS_SUBJECT"));var e=S("VIDEO_TITLE");c[d++]=ca(e);c[d++]="&body=";c[d++]=ca(T("ANNOTATIONS_BODY_1"));c[d++]="%0A";c[d++]=ca(T("ANNOTATIONS_BODY_2"));c[d++]="%0A";c[d++]=ca(a);Va(b,c[F](""))
                }
            }
        };var tp=function(a,b,c){
        var d=P(a+"reason");if(d)p(d,b);if(a=P(a+"sub_reason"))p(a,c)
            },wp=function(a,b){
        var c=P("flag_"+a+"checkbox");if(c)if(!c[uc]){
            if(c=P(b)){
                o(c,"- "+T("FLAG_DEFAULT")+" -");up(c)
                }vp("flag_"+a)
            }
        },up=function(a){
        if(a){
            var b=a.Ih;a=a.Hh;b&&xp(P(b));a&&xp(P(a))
            }
        },zp=function(a,b,c,d,e){
        if(a=P(a)){
            up(a);var f=h,i=h;if(d){
                f=P(d);yp(f)
                }if(e){
                i=P(e);yp(i)
                }var k=h;if(i)k=i;else if(d)k=f;if(a){
                if(k)o(a,k[ob]);a.Ih=d;a.Hh=e
                }vh(c,j);vh(b,j)
            }
        },vp=function(a){
        for(var b=["MoreInfo1","MoreInfo2",
            "MoreInfo3","MoreInfo4","MoreInfo5","MoreInfo6","Error"],c=0;c<b[x];c++){
            var d=P(a+b[c]);d&&W(d)
            }
        },Ap=function(a){
        if(a){
            p(a.flag_reason,"");p(a.flag_sub_reason,"");p(a.flag_t_secs,"");p(a.flag_t_mins,"");p(a.flag_desc,"");p(a.flag_protected_group,"")
            }
        },Bp=function(a){
        if(a){
            p(a.flag_anno_reason,"");p(a.flag_anno_sub_reason,"");p(a.flag_anno_t_secs,"");p(a.flag_anno_t_mins,"");p(a.flag_anno_desc,"");p(a.flag_anno_protected_group,"")
            }
        },Cp=function(a,b){
        if(a==S("COMPLAINT_REASON_RACIALLY_OR_ETHNICALLY_OFFENSIVE_CONTENT")&&
            b==S("COMPLAINT_SUBREASON_PROMOTES_HATRED"))return g;return j
        },Dp=function(a,b){
        if(a==S("COMPLAINT_REASON_GRAPHIC_VIOLENCE")&&b==S("COMPLAINT_SUBREASON_ADULTS_FIGHTING"))return g;return j
        },Ep=function(a,b){
        if(a==S("COMPLAINT_REASON_PORNOGRAPHY_OR_OBSCENITY")&&b==S("COMPLAINT_SUBREASON_SEXUALLY_SUGGESTIVE"))return g;return j
        },Fp=function(a,b,c,d){
        var e="";e=a!=""?Cp(a,b)?"reportConcernResult3":(a==S("COMPLAINT_REASON_RACIALLY_OR_ETHNICALLY_OFFENSIVE_CONTENT")&&b==S("COMPLAINT_SUBREASON_BULLYING")?
            g:j)?"reportConcernResult6":Dp(a,b)||Ep(a,b)?"reportConcernResult2":"reportConcernResult1":Cp(c,d)?"reportConcernResult3":Dp(c,d)||Ep(c,d)?"reportConcernResult2":"reportConcernResult1";xh(e)
        },Gp=function(a,b,c){
        var d=P("flag"+a+"_t_mins"),e=P("t_mins"+a);if(d&&e)p(d,e[v]);e=P("flag"+a+"_t_secs");d=P("t_secs"+a);if(e&&d)p(e,d[v]);e=P("flag"+a+"_desc");var f=P("desc"+a);if(e&&d)p(e,f[v]);if(d=P("flag"+a+"_protected_group"))p(d,"");if(Cp(b,c))if(b=P("protected_group"+a)){
            if(b[Oc][b[rc]][v]==""){
                xh("flag"+
                    a+"_Error");return j
                }if(d)p(d,b[Oc][b[rc]][v])
                }return g
        },xp=function(a){
        if(a){
            a[C].backgroundColor="";a[C].color=""
            }
        },yp=function(a){
        if(a){
            a[C].backgroundColor="#6681ba";a[C].color="#fff"
            }
        };var Hp=function(){
        var a=lk.c();a.ic(Y.rc,g);a[Dc]();W("watch_page_survey")
        };l.yt=l.yt||{};I("_gel",P,void 0);I("_hasclass",N,void 0);I("_addclass",L,void 0);I("_removeclass",M,void 0);I("_showdiv",V,void 0);I("_hidediv",W,void 0);I("_ajax",Ah,void 0);I("goog.dom.getElementsByTagNameAndClass",R,void 0);I("goog.dom.getFirstElementChild",yf,void 0);I("goog.array.forEach",K,void 0);I("goog.array.indexOf",Ud,void 0);I("goog.array.contains",Yd,void 0);I("yt.dom.hasAncestor",function(a,b,c){
        a=P(a);b=P(b);return!!Df(a,function(d){
            return d===b
            },g,c)
        },void 0);I("yt.setConfig",Xf,void 0);
    I("yt.getConfig",S,void 0);I("yt.registerGlobal",Yf,void 0);I("yt.setTimeout",Zf,void 0);I("yt.setInterval",$f,void 0);I("yt.clearTimeout",ag,void 0);I("yt.clearInterval",bg,void 0);I("yt.setMsg",function(){
        Wf(Tf,arguments)
        },void 0);I("yt.getMsg",T,void 0);I("yt.events.listen",U,void 0);I("yt.events.unlisten",tg,void 0);I("yt.events.stopPropagation",xg,void 0);I("yt.events.preventDefault",yg,void 0);I("yt.events.getTarget",vg,void 0);I("yt.events.clear",ug,void 0);I("yt.events.Event",og,void 0);
    sa(og[y],og[y][vb]);Pa(og[y],og[y][Ac]);I("yt.pubsub.subscribe",pl,void 0);I("yt.pubsub.unsubscribeByKey",function(a){
        var b=ud("yt.pubsub.instance_");return b?b.unsubscribeByKey(a):j
        },void 0);I("yt.pubsub.publish",ql,void 0);I("yt.www.init",im,void 0);I("yt.www.dispose",jm,void 0);U(l,"load",im);U(l,"unload",jm);
    l.onerror=function(a,b,c){
        var d=P("www-core-js");if(!(hm||!d||d.src[w]("/debug/")==-1)){
            a:if(Ve){
                try{
                    eval("(0)()")
                    }catch(e){
                    c=e[Cc][u](/(.*):/g,"")[u](/\n/g,",");break a
                    }c=void 0
                }else c=c;vi("jserror","error="+ca(a)+"&script="+ca(b)+"&linenumber="+ca(c)+"&url="+ca(l[B][Zc]));hm=g
            }
        };var Ip=function(a,b){
        var c=b[v],d="";if(Qf(c))d="rtl";else Qf(c)||(d="ltr");b.dir=d
        };I("goog.i18n.bidi.isRtlText",Qf,void 0);I("goog.i18n.bidi.setDirAttribute",Ip,void 0);I("yt.style.toggle",xh,void 0);
    I("yt.style.setDisplayed",sh,void 0);I("yt.style.isDisplayed",th,void 0);I("yt.style.setVisible",vh,void 0);I("yt.net.ajax.sendRequest",X,void 0);I("yt.net.ajax.getRootNode",Ch,void 0);I("yt.net.ajax.getNodeValue",Dh,void 0);I("yt.net.delayed.register",function(a,b,c){
        a=P(a);c=c||Fd(a);c in vl||(vl[c]=[]);vl[c][t]([a,b]);wl[c]=j;return c
        },void 0);I("yt.net.delayed.load",xl,void 0);I("yt.net.delayed.markAsLoaded",function(a){
        if(a in vl)wl[a]=g
            },void 0);I("goog.dom.forms.getFormDataString",Nf,void 0);
    I("yt.uri.buildQueryData",Lg,void 0);I("yt.uri.appendQueryData",Mg,void 0);I("yt.flash.isFlashVersionSupported",Og,void 0);I("yt.flash.canPlayV8Swf",function(){
        return Og(8,0,0)
        },void 0);I("yt.flash.canPlayV9Swf",function(){
        return Og(9,0,0)
        },void 0);I("yt.flash.canPlayH264Videos",function(){
        return Og(9,0,115)
        },void 0);I("yt.flash.supportsPixelBender",function(){
        return Og(10,0,0)
        },void 0);I("yt.net.cookies.set",Ug,void 0);I("yt.net.cookies.get",Vg,void 0);I("yt.net.cookies.remove",Wg,void 0);
    var Jp=lk.c();I("yt.UserPrefs",Jp,void 0);I("yt.UserPrefs.Flags",Y,void 0);var Kp=lk.c().ci;I("yt.UserPrefs.getFlag3",Kp,void 0);var Lp=lk.c().Wj;I("yt.UserPrefs.setFlag3",Lp,void 0);I("yt.window.redirect",cm,void 0);I("yt.window.popup",dm,void 0);I("yt.www.displayLoading",function(a){
        o(P(a),'<img src="http://s.ytimg.com/yt/img/icn_loading_animated-vfl24663.gif">')
        },void 0);I("SWFObject",Rd,void 0);Rd[y].addParam=Rd[y].Ca;Rd[y].addVariable=Rd[y].I;Rd[y].setAttribute=Rd[y][Ub];Rd[y].write=Rd[y][Bb];Rd[y].useExpressInstall=Rd[y].Cf;
    xi(Di);xi(em);xi(Ei);xi(fm);xi(gm);xi(Fi);
    I("yt.www.watch.player.write",function(a,b,c,d,e,f,i){
        e=e||480;var k=f||385,s=i||"#000000",z=7,O=j,G=S("SWF_URL");i=S("SWF_ARGS");var Q=S("SWF_EXPRESS_URL");f=S("SWF_GAM_URL");var ga=S("SWF_IS_PLAYING_ALL"),Da=S("SWF_SET_WMODE"),Yc=S("SWF_AD_EURL"),Za=gp();if(h==Za&&Ro()){
            var Jb=Uo(S("VIDEO_ID"));if(Jb&&Jb>20){
                Za=Jb-20;i.resume="1"
                }
            }if(b)z=0;else if(c){
            z=c;O=g
            }b=new Rd(G,"movie_player",e,k,z,s);O&&Q&&b.Cf(Q);b.Ca("allowFullscreen","true");if(l!=l.top){
            c=m[Tb][$c](0,128);Ng(c)||(i.framer=ca(c))
            }for(var Hd in i)b.I(Hd,
            i[Hd]);f&&b.I("gam",f);ga||b.I("playnext",0);Da&&b.Ca("wmode","opaque");Yc&&b.I("ad_eurl",Yc);Za&&b.I("start",Za);b.I("enablejsapi",1);d&&b.I("jsapicallback",d);b.Ca("AllowScriptAccess","always");Xf("PLAYER_WRITTEN",b[Bb](a));return b
        },void 0);
    I("onYouTubePlayerReady",function(){
        No=g;var a=P("movie_player");a[Sb]("onStateChange","handleWatchPagePlayerStateChange");a[Sb]("onPlaybackQualityChange","onPlayerFormatChanged");a[Sb]("NEXT_CLICKED","yt.www.watch.player.onPlayerNextClicked");a[Sb]("SIZE_CLICKED","yt.www.watch.player.onPlayerSizeClicked");a[Sb]("NEXT_SELECTED","yt.www.watch.player.onPlayerNextSelected");Ro()&&U(l,"beforeunload",Vo);Xo();Kg(l[B][ab]).q&&S("WIDE_PLAYER_STYLES")&&Dk(j,g);if(a=P("watch-player"))a[C].background="transparent"
            },
    void 0);I("handleWatchPagePlayerStateChange",function(a){
        if(a==0){
            S("LIST_AUTO_PLAY_ON")&&Lo();S("SHOW_SUBSCRIBE_UPSELL")&&el(T("SUBSCRIBE_UPSELL_MESSAGE"))
            }
        },void 0);I("onPlayerFormatChanged",Wo,void 0);I("movie_player_DoFSCommand",function(a){
        a=="onPlayerFormatChanged"&&Wo(arguments[1])
        },void 0);I("yt.www.watch.player.enableWideScreen",$o,void 0);I("yt.www.watch.player.enableVideoQualityDisplay",function(){
        Oo=g;Mo&&Wo(Mo)
        },void 0);I("yt.www.watch.player.onPlayerNextClicked",Yo,void 0);
    I("yt.www.watch.player.onPlayerSizeClicked",ap,void 0);I("yt.www.watch.player.onPlayerNextSelected",bp,void 0);I("yt.www.watch.player.seekTo",cp,void 0);
    I("yt.www.watch.player.openPopup",function(a,b,c){
        var d=h,e=P("movie_player");a="/watch_popup?v="+a;if(e){
            a+="&vq="+e.getPlaybackQuality();d=n[ib](e.getCurrentTime());e.stopVideo()
            }if(S("POPOUT_AD_SLOTS"))a+="&pop_ads="+S("POPOUT_AD_SLOTS");if(S("SEQUENTIAL_VIDEO_LIST")[x]>0)a+="&playlist="+S("SEQUENTIAL_VIDEO_LIST");if(d&&d>10)a+="#t="+d;dm(a,{
            width:b,
            height:c,
            resizable:g
        })
        },void 0);I("yt.www.watch.player.openFullScreenPopup",dp,void 0);I("yt.www.watch.player.checkCurrentVideo",ep,void 0);
    I("yt.www.watch.player.trackAnnotationsEvent",hp,void 0);I("yt.www.watch.player.handleShare",ip,void 0);I("yt.www.watch.player.reportTiming",jp,void 0);I("yt.www.watch.player.processLocationHashSeekTime",gp,void 0);I("yt.www.watch.player.handleHashArgumentsOnWatchLoad",function(){
        var a=Kg(l[B][ab]),b=j;if(a.fav){
            delete a.fav;b=g
            }if(a.at){
            delete a.at;b=g
            }if(a.q){
            bl(a.q,a[cb],a.st);b=g
            }if(b)oa(l[B],"#!"+Lg(a))
            },void 0);
    Yf("onYouTubePlayerReady","handleWatchPagePlayerStateChange","onPlayerFormatChanged","movie_player_DoFSCommand");$f(function(){
        if(No){
            var a=l[B][ab];if(a!=Po){
                Po=a;a=Kg(a);if(a.t&&a.t!=Qo.t){
                    var b=fp(a.t);cp(b,j)
                    }else if(a.at&&a.at!=Qo.at){
                    b=fp(a.at);cp(b,j)
                    }Qo=a
                }
            }
        },1E3);I("yt.www.watch.sharing.reset",mp,void 0);I("yt.www.watch.sharing.shareVideo",np,void 0);I("yt.www.watch.sharing.processShareVideo",pp,void 0);
    I("yt.www.watch.sharing.handleShareVideo",function(){
        var a=S("VIDEO_ID");jk("watch-tab-share");N(P("watch-tab-share"),"watch-tab-sel")&&!th("watch-share-video-div")?pp(a,"watch-share-video-div","all"):mp();ip()
        },void 0);
    I("yt.www.watch.sharing.closeShareVideo",function(){
        th("watch-share-video-div")?xh("watch-share-video-div"):xh("shareMessageQuickDiv");lp("fewer-options","more-options");lp("watch-share-services-expanded","watch-share-services-collapsed");xh("shareVideoResult");Zf(function(){
            W("shareVideoResult")
            },3E3)
        },void 0);I("yt.www.watch.sharing.logService",op,void 0);I("yt.www.watch.sharing.hideAndShow",lp,void 0);
    I("yt.www.watch.flagging.report",function(a){
        K(Jo,W);jk("watch-tab-flag");if(S("LOGGED_IN")){
            V("inappropriateVidDiv");P("inappropriateVidDiv")[ob][pd]()[w]("<div")==-1&&Ko(a)
            }else V("inappropriateMsgsLogin")
            },void 0);I("yt.www.watch.about.editSubscription",function(a,b,c){
        ik(a,"username",b,"","",2,ha,ha,g,c)
        },void 0);I("yt.www.watch.embed.generateEmbed",tk,void 0);I("yt.www.watch.embed.getEmbedSize",sk,void 0);
    I("yt.www.watch.about.subscribe",function(a,b,c,d,e,f){
        if(S("LOGGED_IN")){
            var i={};if(d)i.show_recommendations=1;if(e)i.show_sub_channels=1;ik(a,b,c,"subscribeDiv","unsubscribeDiv",0,f,i,g)
            }else{
            a=P("subscribeLoginInvite");V(a)
            }
        },void 0);I("yt.www.watch.about.subscribeWatch5",function(a,b,c,d){
        if(S("LOGGED_IN"))ik(a,b,c,"subscribeDiv","editSubscriptionDiv",0,ha,{
            watch5:g,
            feature:d
        });else{
            a=P("alerts");o(a,'<div id="subscribeMessage">'+P("watch-actions-logged-out")[ob]+"</div>");V(a)
            }
        },void 0);
    I("yt.www.watch.about.unsubscribe",function(a,b,c,d){
        ik(a,b,c,"unsubscribeDiv","subscribeDiv",1,d)
        },void 0);I("yt.www.watch.autoshare.triggerAutosharePromo",function(a){
        var b=lk.c().wa(Y.sc);if(S("SHOW_AUTOSHARE")&&!b){
            V("autoshare-promo-"+a);Xf("SHOW_AUTOSHARE",j)
            }
        },void 0);I("yt.www.watch.autoshare.dismissAutosharePromo",function(a){
        var b=lk.c();b.tb(Y.sc,g);b[Dc]();Xf("SHOW_AUTOSHARE",j);W("autoshare-promo-"+a);a=R(h,"autoshare-promo");for(b=0;b<a[x];b++)wf(a[b])
            },void 0);
    I("yt.www.watch.autoshare.initAutoshareWidget",function(a,b,c){
        Ho=b;W("autoshare-widget-"+a);var d=j,e=j;if(b){
            for(var f in b){
                var i=R("*","autoshare-widget-service-"+f),k=R("*","autoshare-widget-service-auto-"+f),s=P("autoshare-widget-service-checkbox-"+f);if(b[f].is_connected){
                    K(i,V);d=g;if(b[f].is_autosharing){
                        K(k,V);Oa(s,g);e=g
                        }else{
                        K(k,W);Oa(s,j)
                        }
                    }else{
                    K(i,W);K(k,W);Oa(s,j)
                    }
                }if(e){
                V("autoshare-widget-"+a+"-auto");Io=Zf(function(){
                    W("autoshare-widget-"+a+"-auto");V("autoshare-widget-"+a+"-auto-sharing")
                    },
                7E3)
                }else if(d){
                for(f in b)if(b[f].is_connected){
                    s=P("autoshare-widget-service-checkbox-"+f);Oa(s,g)
                    }V("autoshare-widget-"+a+"-oneoff")
                }else if(S("SHOW_AUTOSHARE")){
                V("autoshare-widget-"+a+"-wizard");Xf("SHOW_AUTOSHARE",j)
                }
            }if(c){
            p(P("autoshare-widget-"+a+"-message"),c);o(P("autoshare-widget-"+a+"-message-counter"),130-c[x])
            }V("autoshare-widget-"+a)
        },void 0);I("yt.www.watch.autoshare.toggleShareToService",function(a){
        a=P("autoshare-widget-service-checkbox-"+a);Oa(a,!a[uc])
        },void 0);
    I("yt.www.watch.autoshare.updateMessageCount",function(a,b){
        if(b[v][x]>130)p(b,b[v][jb](0,130));var c=P(b.id+"-counter");if(c)o(c,130-b[v][x]);Ip(a,b)
        },void 0);I("yt.www.watch.autoshare.customizePost",function(a){
        ag(Io);W("autoshare-widget-"+a+"-auto");V("autoshare-widget-"+a+"-oneoff");if(a=P("autoshare-widget-"+a+"-message")){
            a[Kb]();a[Pb]()
            }
        },void 0);
    I("yt.www.watch.autoshare.cancelPost",function(a){
        ag(Io);W("autoshare-widget-"+a+"-auto");W("autoshare-widget-"+a+"-oneoff");V("autoshare-widget-"+a+"-cancelling");p(P("autoshare-widget-"+a+"-cancelled-input"),"true");var b={
            method:"POST",
            postBody:Nf(m[$a]["autoshareWidgetForm-"+a]),
            onComplete:function(){
                W("autoshare-widget-"+a+"-cancelling");V("autoshare-widget-"+a+"-cancelled")
                }
            };X("/autoshare?action_ajax_share=1&cancelled=1",b)
        },void 0);
    I("yt.www.watch.autoshare.share",function(a){
        var b=j;for(var c in Ho){
            var d=P("autoshare-widget-service-checkbox-"+c),e=R("*","autoshare-widget-service-auto-"+c);if(d[uc]){
                K(e,V);b=g
                }else K(e,W)
                }if(b){
            W("autoshare-widget-"+a+"-auto");W("autoshare-widget-"+a+"-oneoff");V("autoshare-widget-"+a+"-sharing");b={
                method:"POST",
                postBody:Nf(m[$a]["autoshareWidgetForm-"+a]),
                onComplete:function(){
                    W("autoshare-widget-"+a+"-sharing");V("autoshare-widget-"+a+"-shared")
                    }
                };X("/autoshare?action_ajax_share=1",b)
            }else alert("No services selected.")
            },
    void 0);I("yt.www.watch.ads.handleSetCompanion",io,void 0);I("yt.www.watch.ads.handleSetCompanionForInstream",jo,void 0);I("yt.www.watch.ads.handleSetCompanionForLongform",ko,void 0);I("yt.www.watch.ads.handleSetCompanionForFreewheel",lo,void 0);I("yt.www.watch.ads.handleHideCompanion",mo,void 0);I("yt.www.watch.ads.handleHideCompanionForInstream",no,void 0);I("yt.www.watch.ads.disablePopoutButton",ro,void 0);I("yt.www.watch.ads.enablePopoutButton",so,void 0);
    I("yt.www.watch.ads.handleCloseMpuCompanion",oo,void 0);I("yt.www.watch.ads.handleAdLoaded",po,void 0);I("yt.www.watch.ads.updatePopoutAds",qo,void 0);I("yt.www.watch.ads.handleSetAfvCompanionVars",to,void 0);I("yt.www.watch.ads.handleShowAfvCompanionAdDiv",uo,void 0);I("yt.www.watch.ads.handleHideAfvInstreamCompanionAdDiv",vo,void 0);I("yt.www.watch.ads.handleShowGutCompanion",wo,void 0);I("yt.www.watch.quicklist.clickedAddIcon",yn,void 0);
    I("yt.www.watch.quicklist.clickedAddIcon_w5",function(a,b,c,d,e,f){
        L(P(a),"in-quicklist");yn(b,c,d,e,f)
        },void 0);I("yt.www.watch.ajax.init",function(){
        pl("navigate",function(){
            Eo()
            });sl(g);Go()
        },void 0);I("yt.www.watch.ajax.initReady",function(){
        var a=$.timer;if(Ao&&a){
            te(a,Ao);Ao=h
            }yo=g
        },void 0);
    I("yt.www.watch.watch5.search",function(a,b){
        if(a)p(P("masthead-search-term"),a);var c=P("masthead-search-term")[v];if(S("AJAX_MODE")){
            var d=Kg(l[B][ab]);d.q=c;if(b)d.page=b;else delete d[cb];if(d.v)Zk=d.v;delete d.v;oa(l[B],"#!"+Lg(d))
            }else bl(c,b)
            },void 0);I("yt.www.watch.watch5.closeSearch",Ck,void 0);
    I("yt.www.watch.watch5.closeContent",function(){
        if($k()){
            W("watch-headline-container","watch-video-container","watch-main-container");al();var a=m[$a].searchForm,b=P("masthead-search-term");Qa(l,a[cd]+"?"+b[cc]+"="+b[v])
            }
        },void 0);I("yt.www.watch.watch5.resizeForSearch",al,void 0);I("yt.www.disco.watch5.toggleDiscoList",function(a,b,c,d){
        a+="-";for(b=b;b<c;b++)if(d){
            W(a+b);W(a+"less");V(a+"more")
            }else{
            V(a+b);V(a+"less");W(a+"more")
            }
        },void 0);
    I("yt.www.disco.watch5.discoSearch",function(a,b){
        var c=!N(P("page"),"search-mode")&&P("watch-disco-search-term")!=h;if(c){
            vi("discoOnWatchFlip");if(P("watch-disco-search-term"))a=P("watch-disco-search-term")[v]
                }else{
            if(P("watch-disco-search-term"))p(P("watch-disco-search-term"),a);var d=Kg(l[B][ab]);d.q=a;d.st="disco";oa(l[B],S("AJAX_MODE")?"#!"+Lg(d):"#"+Lg(d))
            }bl(a,"","disco",c);if(b){
            yg(b);xg(b)
            }
        },void 0);
    I("yt.www.disco.watch5.handleToggleArtistBio",function(a){
        var b=N(a,"yt-uix-expander-collapsed");ge(a,"expanded",!b);if(!b){
            a=P(a.id+"-body");Ya(a[E][C],a[md]+"px")
            }
        },void 0);I("yt.www.disco.watch5.handleDiscoRowMouseEvent",function(a,b){
        var c=(b||l[rd])[Zb],d=R(h,"watch-disco-video-queue-end",a)[0],e=R(h,"watch-disco-video-queue-next",a)[0];if(c=="mouseover"){
            vh(d,g);vh(e,g)
            }else if(c=="mouseout"){
            vh(d,j);vh(e,j)
            }
        },void 0);
    I("yt.www.disco.watch5.addVideoToQueueNext",function(a,b){
        var c=Ud(sn(),S("VIDEO_ID"));c==-1?Bn(a):yn(h,a,j,"","","disco_add_to_queue_next",c+1);if(b){
            yg(b);xg(b)
            }
        },void 0);I("yt.www.disco.watch5.addVideoToQueueEnd",Bn,void 0);I("yt.www.watch.watch5.hideBrowserUpgrade",function(){
        V("movie_player");W("browser-upgrade-outer-box");M(P("watch-video"),"deprecated-browser");M(P("watch-sidebar"),"deprecated-browser")
        },void 0);I("yt.history.enable",sl,void 0);I("yt.history.disable",tl,void 0);
    I("yt.flash.embed",Pg,void 0);I("yt.flash.update",Qg,void 0);I("yt.help.guide.start",function(a){
        if(l.guidedhelp&&l.guidedhelp.loaded?g:j)jl(a);else{
            l.guidedhelp=l.guidedhelp||{};l.guidedhelp.onLoad=function(){
                var b=ud("help.guide.init");if(b){
                    b("http://www.google.com/support/youtube",S("GUIDED_HELP_LOCALE")||"en_US","v2");jl(a)
                    }
                };hl()
            }return j
        },void 0);I("yt.www.watch.watch5.enableWide",Dk,void 0);I("yt.www.watch.watch5.toggleWide",function(){
        Dk(!Ek())
        },void 0);
    I("yt.www.watch.watch5.isWide",Ek,void 0);I("yt.www.watch.player.enableWideScreen",Dk,void 0);I("yt.www.watch.player.onPlayerNextClicked",Yo,void 0);I("yt.www.watch.player.onPlayerSizeClicked",ap,void 0);I("yt.www.watch.player.onPlayerNextSelected",bp,void 0);I("yt.www.watch.player.showHideNextButton",Xo,void 0);I("yt.www.watch.queue.playNext",Lo,void 0);
    I("yt.www.watch.queue.handleToggleAutoplay",function(a){
        var b=N(a,"autoplay-off"),c=lg("span",h,a);ge(a,"autoplay-on",b);ge(a,"autoplay-off",!b);if(c)o(c,b?T("AUTOPLAY_ON"):T("AUTOPLAY_OFF"));Xf("LIST_AUTO_PLAY_ON",b)
        },void 0);
    I("yt.www.watch.queue.handleToggleShuffle",function(a){
        var b=N(a,"autoplay-off"),c=lg("span",h,a);ge(a,"autoplay-on",b);ge(a,"autoplay-off",!b);if(c)o(c,b?T("SHUFFLE_ON"):T("SHUFFLE_OFF"));Xf("SHUFFLE_ENABLED",b);if(a=Ef(a,"div","watch-active-list")){
            he(a,"shuffled");N(a,"yt-uix-expander-collapsed")?mg(a,"loaded","false"):Vk(a,1,g)
            }
        },void 0);
    I("yt.www.watch.queue.handleListOnclick",function(a){
        var b=Ef(vg(a),"A","video-list-item-link");if(b&&b[Zc]){
            b=b[Zc];if(S("LIST_AUTO_PLAY_ON"))b+="&playnext=1";if(S("SHUFFLE_ENABLED")){
                var c=S("SHUFFLE_VALUE");if(c)b+="&shuffle="+c
                    }cm(b);xg(a);return yg(a)
            }
        },void 0);
    I("yt.www.watch.watch5.handleToggleMoreFromUser",function(a){
        a=N(a,"yt-uix-expander-collapsed");var b=P("watch-more-from-user");if(ng(b,"loaded")!="true"){
            var c={
                method:"GET",
                update:"watch-more-from-user",
                onComplete:function(){
                    mg(b,"loaded","true");gk()
                    }
                };X("/watch_ajax?user="+S("VIDEO_USERNAME")+"&video_id="+S("VIDEO_ID")+"&action_channel_videos_w5",c)
            }ge(b,"collapsed",a)
        },void 0);
    I("yt.www.watch.watch5.handleToggleStats",function(a){
        ge(P("watch-description"),"yt-uix-expander-collapsed",g);var b=P("watch-captions");if(b){
            L(b,"yt-uix-expander-collapsed");L(P("watch-captions-container"),"collapsed")
            }b=N(a,"yt-uix-expander-collapsed");var c=P("watch-info"),d=P("watch-stats");a=d[E];ge(c,"expanded",!b);if(ng(d,"loaded")!="true"){
            b={
                method:"GET",
                update:"watch-stats",
                onComplete:function(){
                    Ya(d[E][C],d[md]+"px")
                    }
                };X("/watch_ajax?v="+S("VIDEO_ID")+"&l="+S("VIDEO_LANGUAGE")+"&action_get_statistics_and_data=1",
                b);V(a);M(a,"collapsed");mg(d,"loaded","true")
            }else{
            ge(a,"collapsed",b);if(b){
                o(d,'<div id="watch-stats-loading">'+T("LOADING")+"</div>");mg(d,"loaded","false")
                }
            }
        },void 0);
    I("yt.www.watch.watch5.handleToggleCaptionViewer",function(a){
        ge(P("watch-description"),"yt-uix-expander-collapsed",g);var b=P("watch-views");if(b){
            L(b,"yt-uix-expander-collapsed");L(P("watch-stats-container"),"collapsed")
            }a=N(a,"yt-uix-expander-collapsed");b=P("watch-info");ge(b,"expanded",!a);b=P("watch-captions-container");ge(P("watch-captions"),"expanded",!a);if(ng(b,"loaded")=="true")ge(b,"collapsed",a);else{
            var c=new pi;c.kb(S("TTS_WATCH_URL"),h,S("VIDEO_ID"));c.Re(function(){
                c.Pe(Ok)
                });M(b,
                "collapsed");mg(b,"loaded","true")
            }
        },void 0);I("yt.www.watch.watch5.handleToggleDescription",function(a){
        var b=P("watch-views");if(b){
            L(b,"yt-uix-expander-collapsed");L(P("watch-stats-container"),"collapsed")
            }if(b=P("watch-captions")){
            L(b,"yt-uix-expander-collapsed");L(P("watch-captions-container"),"collapsed")
            }a=N(a,"yt-uix-expander-collapsed");b=P("watch-info");ge(b,"expanded",!a);if(!a){
            a=P("watch-description-body");Ya(a[E][C],a[md]+"px")
            }
        },void 0);
    I("yt.www.watch.watch5.like",function(){
        Sk();L(P("watch-like"),"active");Tk();if(S("ALLOW_RATINGS")){
            if(Gk())if(!Hk()){
                var a=m[$a].likeForm,b={
                    postBody:Nf(a),
                    onComplete:function(){
                        o(P("watch-actions-area"),P("watch-actions-close")[ob]+P("watch-actions-area")[ob]);Fk()
                        },
                    update:"watch-actions-area",
                    method:"POST"
                };X(a[cd]+"?log_action_like_video=1",b)
                }
            }else o(P("watch-actions-area"),P("watch-actions-close")[ob]+"<em>"+T("RATINGS_DISABLED")+"</em>")
            },void 0);
    I("yt.www.watch.watch5.unlike",function(){
        Sk();L(P("watch-unlike"),"active");Tk();if(S("ALLOW_RATINGS")){
            if(Gk())if(!Hk()){
                var a=m[$a].unlikeForm,b={
                    postBody:Nf(a),
                    onComplete:function(){
                        o(P("watch-actions-area"),P("watch-actions-close")[ob]+P("watch-actions-area")[ob]);Fk()
                        },
                    update:"watch-actions-area",
                    method:"POST"
                };X(a[cd]+"?log_action_unlike_video=1",b)
                }
            }else o(P("watch-actions-area"),P("watch-actions-close")[ob]+"<em>"+T("RATINGS_DISABLED")+"</em>")
            },void 0);
    I("yt.www.watch.watch5.save",function(a,b,c,d,e){
        if(d){
            if(a[Nb]!=13)return;xg(a)
            }a=Ef(b,"FORM","watch-playlists-form");p(a.playlist_id,c);p(a.add_to_favorite,c==""?"on":"");var f=Di.c();f.Rc(P("watch-playlists-button"));if(e)p(a.new_playlist_name,e);Tk();c={
            postBody:Nf(a),
            method:"POST",
            onComplete:function(i){
                f.Af(P("watch-playlists-button"),'<li><span class="yt-uix-button-menu-item">'+T("LOADING")+"</span></li>");(i=i[Sc])&&Ch(i);o(P("watch-actions-area"),P("watch-actions-close")[ob]+P("watch-actions-area")[ob]);
                Fk()
                },
            onException:function(){
                Sk()
                },
            update:"watch-actions-area"
        };X(a[cd]+"?log_action_add_favorite_video&log_add_to_favorite="+a.add_to_favorite[v],c)
        },void 0);I("yt.www.watch.watch5.createPlaylist",function(a,b){
        xg(a);W(b);var c=R(h,"create-playlist-input",b[E])[0];V(c);c=c[gc]("INPUT")[0];c[Kb]();c=Ef(c,"FORM","watch-playlists-form");Ia(c,c[Mb])
        },void 0);
    I("yt.www.watch.watch5.loadPlaylists",function(){
        Sk();if(Gk())if(!R(h,"watch-playlists-form",h)[x]){
            var a={
                method:"GET",
                onComplete:function(b){
                    if(b=(b=b[Sc])?Ch(b):h){
                        b=Dh(b,"html_content")||"";Di.c().Af(P("watch-playlists-button"),b)
                        }
                    }
                };X("/watch_ajax?video_id="+S("VIDEO_ID")+"&action_get_playlists_component=1",a)
            }
        },void 0);I("yt.www.watch.watch5.shareSuccess",function(a){
        Tk();o(P("watch-actions-area"),P("watch-actions-close")[ob]+a)
        },void 0);I("yt.www.watch.watch5.share",Qk,void 0);
    I("yt.www.watch.watch5.shareFromFlashPlayer",Rk,void 0);I("yt.www.watch.watch5.updateShareURL",Uk,void 0);I("yt.www.watch.watch5.url",function(){
        Tk();o(P("watch-actions-area"),P("watch-actions-close")[ob]+'<input id="watch-href" type="textbox" style="width: 350px" onclick="this.focus();this.select();" value="'+l[B][Zc]+'"/>');Zf(function(){
            P("watch-href")[Kb]();P("watch-href")[Pb]()
            },0)
        },void 0);
    I("yt.www.watch.watch5.embed",function(){
        var a=P("watch-actions-area-container");if(!N(a,"collapsed")&&P("watch-customize-embed"))Sk();else{
            Sk();Tk();L(P("watch-embed"),"active");if(S("ALLOW_EMBED")){
                a={
                    method:"GET",
                    onComplete:function(){
                        o(P("watch-actions-area"),P("watch-actions-close")[ob]+P("watch-actions-area")[ob]);xk();Fk();Zf(function(){
                            var b=P("watch-embed-code");b[Kb]();b[Pb]()
                            },0)
                        },
                    update:"watch-actions-area"
                };X("/watch_ajax?action_customize_embed=1&new_embed=1"+(S("IS_WIDESCREEN")?"&wide=1":
                    "")+(S("IS_HD_AVAILABLE")?"&hd=1":""),a)
                }else o(P("watch-actions-area"),P("watch-actions-close")[ob]+'<p id="watch-customize-embed"><em>'+T("EMBEDDING_DISABLED")+"</em></p>")
                }
        },void 0);
    I("yt.www.watch.watch5.flag",function(a){
        var b=P("watch-actions-area-container");if(!N(b,"collapsed")&&P("watch-flag-form"))Sk();else{
            Sk();Tk();L(P("watch-flag"),"active");if(Gk()){
                b="/watch_ajax?video_id="+S("VIDEO_ID")+"&action_get_flag_video_component=1";if(ng(a,"from-dislike")=="1")b+="&from_dislike=1";X(b,{
                    method:"GET",
                    onComplete:function(){
                        kk();o(P("watch-actions-area"),P("watch-actions-close")[ob]+P("watch-actions-area")[ob]);Fk()
                        },
                    update:"watch-actions-area"
                })
                }
            }
        },void 0);
    I("yt.www.watch.watch5.hide",Sk,void 0);I("yt.www.comments.watch5.inputFocus",jn,void 0);I("yt.www.comments.watch5.inputBlur",function(a){
        var b=Ef(a,"FORM");b&&M(b,"input-focused");tg(a,"input",hn);tg(a,"propertychange",hn)
        },void 0);
    I("yt.www.comments.watch5.cancelPost",function(a){
        qn();if(a=Ef(a,"FORM"))if(a.id=="comments-post-form"){
            p(lg(h,"comments-textarea",a),"");M(a,"input-expanded");L(a,"input-collapsed");W("comments-attach-video");a=R("BUTTON","comments-reaction-button",P("reaction-buttons"));K(a,function(b){
                M(b,"yt-button-disabled")
                })
            }else a[E][Kc](a)
            },void 0);
    I("yt.www.comments.watch5.post",function(a){
        a=Ef(a,"FORM");var b=a.comment,c=R(h,"watch-comments-post",a)[0],d=R(h,"comments-post-result",a)[0];o(d,"");var e=P("screen");if(e)p(e,"h="+ea[kd]+"&w="+ea[hb]+"&d="+ea.colorDepth);if(!N(c,"yt-button-disabled")){
            e=a[cd];a={
                postBody:Nf(a),
                onComplete:function(f){
                    var i=Dh(f[Sc],"str_code");o(d,i=="OK"?T("COMMENT_OK"):T("COMMENT_ERROR"));i!="INLINE_CAPTCHAFAIL"&&qn();if(i=="OK"){
                        M(d,"comments-bad-post");L(d,"comments-good-post");L(c,"yt-button-disabled");i=
                        P("comments-view");if(ng(i,"type")=="everything")if(i=lg(h,"comment-list",i)){
                            f=Dh(f[Sc],"html_content");o(i,f+i[ob])
                            }
                        }else if(i=="INLINE_CAPTCHA"){
                        o(d,"");var k=uf("DIV");k.id="captcha_div";X("/comment_servlet?gimme_captcha=1&watch5=1",{
                            update:k,
                            onComplete:function(){
                                sh(b,j);M(c,"yt-button-disabled");b[E]&&b[E][xb](k,b)
                                }
                            })
                        }else if(i=="INLINE_CAPTCHAFAIL"){
                        o(d,"");f=P("fail_warning");o(P("fail_warning_text"),T("COMMENT_CAPTCHAFAIL"));V(f);M(c,"yt-button-disabled")
                        }
                    },
                onException:function(f){
                    f=Dh(f[Sc],
                        "str_code");if(f=="PENDING")o(d,T("COMMENT_PENDING"));else{
                        o(d,f=="BLOCKED"?T("COMMENT_BLOCKED"):T("COMMENT_ERROR"));M(c,"yt-button-disabled")
                        }L(d,"comments-bad-post");M(d,"comments-good-post")
                    }
                };e+="&len="+b[v][x]+"&wc="+b[v][A](" ")[x];X(e,a);L(c,"yt-button-disabled")
            }
        },void 0);I("yt.www.comments.watch5.showPage",nn,void 0);I("yt.www.comments.watch5.showPageFromElement",function(a){
        nn(a[Qc]("data-page"));return j
        },void 0);
    I("yt.www.comments.watch5.react",function(a,b){
        if(!N(a,"yt-button-disabled")){
            var c=P("comments-post-form"),d=R(h,"comments-textarea",c)[0];c="#"+b+" ";if(m.selection){
                d[Kb]();ra(m.selection.createRange(),c)
                }else if(d[Jc]||d[Jc]=="0"){
                var e=d[Jc],f=d.selectionEnd;p(d,d[v][$c](0,e)+c+d[v][$c](f,d[v][x]));d.selectionStart=e+c[x];d.selectionEnd=d[Jc]
                }else d.value+=c;L(a,"yt-button-disabled");Zf(function(){
                d[Kb]()
                },1)
            }
        },void 0);
    I("yt.www.comments.watch5.vote",function(a){
        if(gn()){
            var b=fn;if(!ng(b,"voted")){
                var c=S("VIDEO_ID"),d=ng(b,"id"),e=ng(b,"score");a=ng(a,"vote-increment");c="/comment_voting?a="+a+"&id="+d+"&video_id="+c+"&old_vote="+e;if(b[qb]?"tag"in b[qb]:b.hasAttribute?!!b.hasAttribute("data-tag"):!!b[Qc]("data-tag"))c+="&tag="+ng(b,"tag");X(c,{
                    method:"GET",
                    onComplete:function(){}
                    });mg(b,"voted",a);on(b)
                }
            }
        },void 0);
    I("yt.www.comments.watch5.reply",function(){
        if(gn()){
            qn();var a=P("comments-post-form")[Yb](g);a.id="";q(a,"comments-reply-form");var b=lg(h,"watch-comments-post",a);M(b,"yt-button-disabled");o(lg(h,"comments-post-result",a),"");p(lg(h,"comment-parent-id",a),ng(fn,"id"));a.action+="&reply=1";if(b=ng(fn,"tag"))a.action+="&tag="+b;b=R(h,"comments-reply-form",fn);K(b,function(d){
                fn[Kc](d)
                });fn[r](a);jn(a[Ob]);b=ng(fn,"author");var c=lg(h,"comments-textarea",a);p(c,"@"+b+" ");c[Kb]();dn(c,c[ob][x]);kn(a[Ob]);
            on(fn)
            }
        },void 0);I("yt.www.comments.watch5.flag",function(){
        if(gn()){
            var a=S("VIDEO_ID");a="/comment_servlet?mark_comment_as_spam="+ng(fn,"id")+"&entity_id="+a;X(a,{});a=R(h,"content",fn)[0];L(a,"hide-comment");mg(fn,"flagged","True")
            }
        },void 0);I("yt.www.comments.watch5.block",function(){
        var a=ng(fn,"author");a&&pn(a,g)
        },void 0);I("yt.www.comments.watch5.unblock",function(){
        var a=ng(fn,"author");a&&pn(a,j)
        },void 0);I("yt.www.comments.watch5.showActions",on,void 0);
    I("yt.www.comments.watch5.hideActions",mn,void 0);I("yt.www.comments.watch5.approve",function(a,b){
        var c=fn,d=ng(c,"id"),e=ng(P("comments-post-form"),"comment-type");X("/comment_servlet?field_approve_comment=1",{
            postBody:"comment_id="+d+"&comment_type="+e+"&entity_id="+S("VIDEO_ID")+"&"+b,
            onComplete:function(){
                W(a[E]);mg(c,"pending","0");on(c)
                }
            })
        },void 0);
    I("yt.www.comments.watch5.remove",function(a,b){
        var c=fn,d=ng(c,"id"),e=ng(P("comments-post-form"),"comment-type");d={
            postBody:"deleter_user_id="+a+"&comment_id="+d+"&"+b,
            onComplete:function(){
                W(c);mn()
                }
            };X("/comment_servlet?remove_comment=1&comment_type="+e+"&entity_id="+S("VIDEO_ID"),d)
        },void 0);I("yt.www.comments.watch5.updateCount",kn,void 0);
    I("yt.www.comments.watch5.display",function(a,b){
        if(b){
            M(fn,"hidden");M(a[E],"hide-mode");L(a[E],"show-mode")
            }else{
            L(fn,"hidden");L(a[E],"hide-mode");M(a[E],"show-mode")
            }
        },void 0);I("yt.www.comments.watch5.handleCommentMouseEvent",function(a,b){
        var c=P("comments-actions"),d=(b||l[rd])[Zb],e=Df(wg(b),function(f){
            return f===a||f===c
            },g,6);if(!(!a||e))if(d=="mouseover")on(a);else d=="mouseout"&&mn()
            },void 0);
    I("yt.www.comments.viewing.rotateVideoResponses",function(a,b,c,d){
        xl("video_bar");var e=P("video-bar-container-box-"+b);b=P("video-bar-long-box-"+b);b=ia(b[C].marginLeft,10);c=(c-1)*e[tc]*-1;if(a&&b>c||!a&&b<0)d.Gb(b,b+(a?-1:1)*e[tc])
            },void 0);I("yt.www.watch.watch5.toggleNextList",function(a){
        if(!ng(a,"loaded")||ng(a,"loaded")=="false")Vk(a,1,g);else{
            a=P("watch-next-list-body");var b=lg(h,"next-list-current",a);if(b)Ia(a,b[jd])
                }
        },void 0);I("yt.www.watch.watch5.togglePassiveList",Wk,void 0);
    I("yt.www.watch.watch5.clearQuicklist",function(){
        la(T("QUEUE_CLEAR"))&&X("/watch_queue_ajax?action_clear_queue=1",{
            postBody:Xk(),
            onComplete:function(){
                var a=Yk();o(P(a.id+"-body"),'<div class="quicklist-help"><em>'+T("QUEUE_EMPTY")+"</em></div>");o(P(a.id+"-count"),"0")
                }
            })
        },void 0);
    I("yt.www.watch.watch5.showQuicklistPlaylists",function(a){
        var b=P(a);P(b.id+"-body");a=R(h,"watch-playlist-actions",b)[0];b=R(h,"watch-module-body",b)[0];L(b,"actions-shown");V(a);if(Gk())X("/watch_ajax?action_get_playlists=1",{
            method:"GET",
            update:a
        });else o(a,P("watch-actions-logged-out")[ob])
            },void 0);
    I("yt.www.watch.watch5.getSaveQuicklistForm",function(a){
        var b=P(a);P(b.id+"-body");a=R(h,"watch-playlist-actions",b)[0];b=R(h,"watch-module-body",b)[0];L(b,"actions-shown");V(a);if(Gk())X("/watch_ajax?action_get_save_quicklist_form=1",{
            method:"GET",
            update:a
        });else o(a,P("watch-actions-logged-out")[ob])
            },void 0);I("yt.www.watch.watch5.saveQuicklist",function(){
        var a=m[$a]["save-quicklist"],b=a[E];if(a[qc]){
            b={
                postBody:Nf(a),
                method:"POST",
                onComplete:function(){},
                update:b
            };X(a[cd],b)
            }
        },void 0);
    I("yt.www.watch.watch5.selectPlaylist",function(){
        var a=P("watch-playlists-select");if(a)Va(l[B],a[v])
            },void 0);I("ieThumbEvent",function(a,b){
        if(cg){
            xg(a);yg(a);Ef(b,"a",h).click()
            }
        },void 0);I("yt.www.watch.watch5.handleListItemMouseEvent",function(a,b){
        var c=(b||l[rd])[Zb],d=R(h,"video-list-item-delete",a)[0],e=R(h,"video-list-item-gripper",a)[0];if(c=="mouseover"){
            vh(d,g);vh(e,g)
            }else if(c=="mouseout"){
            vh(d,j);vh(e,j)
            }
        },void 0);I("yt.www.watch.quicklist.getWatchQueue",sn,void 0);
    I("yt.www.watch.quicklist.saveVideosToWatchQueue",zn,void 0);I("yt.www.watch.quicklist.isInWatchQueue",un,void 0);I("yt.www.watch.quicklist.onAddAllToQueue",function(a,b){
        var c=[];for(var d in a)un(a[d])||c[t](a[d]);if(c[x]){
            d=sn();be(d,c);zn(d);wn(2);tn();xn();b&&vi(b)
            }
        },void 0);I("yt.www.watch.quicklist.onQuickDeleteClick",function(a,b,c){
        An(a);wn(3);tn();xn();if(b){
            yg(b);xg(b)
            }c&&vi(c)
        },void 0);
    I("yt.www.watch.quicklist.moveVideoInWatchQueue",function(a,b){
        if(a!=b){
            var c=sn();if(!(a<0||a>=c[x]))if(!(b<0||b>=c[x])){
                var d=Yk();d=P(d.id+"-body");d=ae(R("li","edit-list-item",d));var e=d[b];e[E]&&e[E][xb](d[a],e[dc]);if(a>b)b+=1;d=c[ld](a,1);de(c,b,0,d);zn(c);wn(3);xn()
                }
            }
        },void 0);I("yt.www.watch.quicklist.addToWatchQueue",vn,void 0);I("yt.www.watch.quicklist.deleteFromWatchQueue",An,void 0);I("yt.www.watch.quicklist.clearWatchQueue",function(){
        zn([])
        },void 0);I("yt.dom.datasets.get",ng,void 0);
    I("yt.uri.parseFragmentData",Kg,void 0);I("yt.www.watch.watch5.promoteSubscribe",el,void 0);I("openFull",dp,void 0);I("checkCurrentVideo",ep,void 0);I("trackAnnotationsEvent",hp,void 0);I("reportFlashTiming",jp,void 0);I("shareVideoFromFlash",Rk,void 0);I("setCompanion",io,void 0);I("setInstreamCompanion",jo,void 0);I("setLongformCompanion",ko,void 0);I("setFreewheelCompanion",lo,void 0);I("closeInPageAdIframe",mo,void 0);I("hideInstreamCompanion",no,void 0);I("disablePopout",ro,void 0);
    I("enablePopout",so,void 0);I("closeMpuCompanion",oo,void 0);I("handleAdLoaded",po,void 0);I("updatePopAds",qo,void 0);I("setAfvCompanionVars",to,void 0);I("showAfvCompanionAdDiv",uo,void 0);I("hideAfvInstreamCompanionAdDiv",vo,void 0);I("show_ppv_in_yva_spot",Xm,void 0);I("requestPyvAds",$m,void 0);I("pyvHomeRequestAds",$m,void 0);I("pyvBrowseRequestAds",bn,void 0);I("showGutCompanion",wo,void 0);
    Yf("openFull","checkCurrentVideo","trackAnnotationsEvent","reportFlashTiming","shareVideoFromFlash","setCompanion","setInstreamCompanion","setLongformCompanion","setFreewheelCompanion","closeInPageAdIframe","hideInstreamCompanion","disablePopout","enablePopout","closeMpuCompanion","handleAdLoaded","updatePopAds","setAfvCompanionVars","showAfvCompanionAdDiv","hideAfvInstreamCompanionAdDiv","show_ppv_in_yva_spot","requestPyvAds","pyvHomeRequestAds","pyvBrowseRequestAds","showGutCompanion");
    I("yt.www.embeds.CustomSizes",pk,void 0);I("yt.www.embeds.CustomSizesWide",qk,void 0);I("yt.www.recos.removeRecommendation",function(a){
        W("reco-"+a);a=Mg("/remove_recommendation_ajax",{
            video_id:a
        });X(a,{
            method:"GET"
        });return j
        },void 0);
    I("yt.www.search.toggleAdvSearch",function(a,b,c,d,e,f,i,k,s,z,O,G,Q){
        xh("search-advanced-form");var ga=P("additional-search-option-expander");th(P("search-advanced-form"))?L(ga,"collapsed"):M(ga,"collapsed");if(P("search-advanced-form")[ob][pd]()[w]("<form")!=-1)return j;ga={};ga.action_advanced="1";ga.search_query=a;ga.search_type=b;ga.geo_name=c;ga.geo_latlong=d;ga.search_duration=e;ga.search_hl=f;ga.search_sort=k;ga.uploaded=s;if(z)ga.high_definition=1;if(O)ga.annotations=1;if(G)ga.closed_captions=
            1;if(Q)ga.partner=1;a=Mg("/results_ajax",ga);i=i[A](",");for(b=0;b<i[x];b++)a+="&search_category="+i[b];X(a,{
            method:"GET",
            update:"search-advanced-form"
        });return j
        },void 0);
    I("yt.www.suggest.install",function(a,b,c,d,e,f,i,k){
        Ni=a;Oi=b;oj=c;ij=d;jj=e;nj=ba(f);mj=i;qj=k;if(yj&&l[B][Zc][w]("/watch?")!=-1){
            pj=4;ij=""
            }Ui=/^(zh-(CN|TW)|ja|ko)$/[eb](c);a="yt";if(l[B][Nc][Fb](/^\/show(s$|$|\/)/))a="yt_sh";else if(l[B][Nc]=="/movies")a="yt_mv";Ti="suggestqueries.google.com/complete/search?hl="+c+"&ds="+a+"&client=youtube&hjson=t&jsonp=window.yt.www.suggest.handleResponse";U(Ni,"submit",Wj);Oi[Ub]("autocomplete","off");U(Oi,"blur",Ej);Oi.onkeyup_original=Oi.onkeyup;if(Oi[Sb]){
            if(vj||
                tj)Oi.onkeydown=Ij;else Oi.onkeypress=Ij;Oi.onkeyup=Jj
            }else{
            U(Oi,uj?"keydown":"keypress",Ij);U(Oi,"keyup",Jj)
            }Li=Ji=Ki=Oi[v];Mi=Lj(Oi);if(i!=2&&l[B][Nc]=="/")Li=Ji="";Pi=P("completeTable");c=j;if(Pi)c=g;else Pi=m[Lb]("table");Pi.id="completeTable";Pi.cellSpacing=Pi.cellPadding="0";Qi=Pi[C];q(Pi,"yt-suggest-table");Dj();c||m[Ic][r](Pi);aj=P("yt-suggest-iframe");c||(aj=m[Lb]("iframe"));bj=aj[C];aj.id="yt-suggest-iframe";c||m[Ic][r](aj);Bj();U(l,"resize",Bj);U(l,"pageshow",zj);Ui&&$f(Yj,10);Ri=Cj("aq",
            "f",j);Si=Cj("oq",Ki,g);if(oj in hj){
            lj=g;ij=""
            }rj=m[Ic][E].dir=="rtl";Nj()
        },void 0);I("yt.www.suggest.handleResponse",function(a){
        cj>0&&cj--;if(a[0]==Ki){
            if(ej){
                ag(ej);ej=h
                }Wi=a[0];Xj(a[1]);if(lj)Vj(Ki,h,"g","g",nj,Pj("http://www.google."+(hj[oj]||"com")+"/search?source=youtube-suggest"+(mj>=0?"-"+mj:"")+"&hl="+oj+"&q="+ca(Wi),g));$i=-1;(Yi=Pi[bd])&&Yi[x]>0?Sj():Dj()
            }
        },void 0);I("yt.www.suggest.setFieldValue",Fj,void 0);I("yt.www.suggest.enable",Zj,void 0);I("yt.www.suggest.disable",$j,void 0);
    I("yt.www.suggest2.install",function(a,b,c,d,e){
        Mn[Jn++]=new Ln(a,b,c,d,e)
        },void 0);I("yt.www.suggest2.handleResponse",function(a){
        Kn&&Kn.xi(a)
        },void 0);I("yt.www.thumbnailDelayLoad.setFudgeFactor",function(a){
        dk=a
        },void 0);I("yt.www.thumbnailDelayLoad.setLoadAllAtOnce",function(a){
        ek=a
        },void 0);I("yt.www.thumbnailDelayLoad.testImage",fk,void 0);I("yt.www.thumbnailDelayLoad.loadImages",gk,void 0);
    I("yt.www.ads.pyv.pyvWatchAfcCallback",function(a){
        if(a[x]==0){
            if(S("PYV_TRACK_RELATED_CTR")){
                cn("watch-related",j);cn("watch-channel-videos-panel",j)
                }
            }else{
            var b=P("watch-channel-videos-panel");b&&!S("IS_BRANDED_WATCH")&&L(b,"yt-uix-expander-collapsed");Ym("watch_related",a[0],h,function(c){
                c=Ch(c[Sc]);c=Dh(c,"html_content");var d=P(l.pyv_related_box_id||"watch-related");if(d){
                    var e=d[ob];if(e[w](c)!=0){
                        o(d,c+e);if(S("PYV_TRACK_RELATED_CTR")){
                            cn("watch-related",g);cn("watch-channel-videos-panel",
                                g)
                            }
                        }
                    }
                },l.google_adtest&&l.google_adtest=="on")
            }
        },void 0);I("yt.www.ads.pyv.pyvHomeAfcCallback",Zm,void 0);I("yt.www.ads.pyv.showPpvAdInYvaSpot",Xm,void 0);I("yt.www.ads.pyv.pyvHomeRequestAds",$m,void 0);I("yt.www.ads.pyv.pyvBrowseRequestAds",bn,void 0);I("MooFx",{},void 0);I("MooFx.Base",gg,void 0);gg[y].clearTimer=gg[y].yc;gg[y].custom=gg[y].Gb;gg[y].set=gg[y].l;gg[y].show=gg[y].show;gg[y].hide=gg[y].jb;I("MooFx.BasicEffect",hg,void 0);I("MooFx.Opacity",ig,void 0);ig[y].toggle=ig[y].yk;
    ig[y].hide=ig[y].jb;I("yt.www.xsrf.dynamicAppendSessionToken",qp,void 0);I("yt.www.xsrf.sessionExcludedForms",rp,void 0);I("yt.www.xsrf.populateSessionToken",function(){
        for(var a=0;a<m[$a][x];a++){
            for(var b=j,c=0;c<rp[x];c++)if(m[$a][a][cc]==rp[c])b=g;c=m[$a][a];if(c.method[pd]()=="post"&&b==j){
                b=j;for(var d=0;d<c[Vb][x];d++)if(c[Vb][d][cc]==S("XSRF_FIELD_NAME"))b=g;b||qp(c)
                }
            }
        },void 0);
    I("yt.www.masthead.performSearch",function(a,b,c){
        var d=m[a];a=ng(c,b)||"";if("rentals"==a){
            p(d.rental,1);p(d.search_type,"")
            }else{
            p(d.search_type,a);p(d.rental,0)
            }if(d.search_query[v])d.submit();else{
            d=c[ob];var e=P("default-search-button"),f=e[ob],i=ng(e,b)||"";o(e,d);mg(e,b,a);o(c,f);mg(c,b,i)
            }return j
        },void 0);
    I("yt.www.masthead.loadPicker",function(a,b,c){
        var d=P(a);if(d)c?V(d):xh(d);else{
            d=uf("div");d.id=a;W(d);P("picker-container")[r](d);c="/masthead_ajax?action_get_"+a[u]("-","_")+"=1";if(b)c=b+c;X(c,{
                method:"GET",
                update:a,
                onComplete:function(){
                    W("picker-loading");V(a);P(a).scrollIntoView()
                    }
                });V("picker-loading")
            }Gi("picker-container",a);P(a).scrollIntoView()
        },void 0);I("yt.www.masthead.searchBarFocusTest",Ii,void 0);I("yt.www.home.ads.mastheadAd",Cn,void 0);Cn[y].collapse_ad=Cn[y].collapse;
    Cn[y].expand_ad=Cn[y].expand;I("yt.www.home.ads.workaroundLoad",function(){
        Dn=g
        },void 0);I("yt.www.home.ads.workaroundIE",function(a){
        if(!(En||!Dn)){
            En=g;Zf(function(){
                a[Kb]()
                },0)
            }
        },void 0);I("yt.www.home.ads.workaroundReset",function(){
        En=j
        },void 0);I("yt.tracking.track",vi,void 0);
    I("yt.tracking.reachability",function(){
        var a=new Date,b=n[Pc]();a="/gen_204?atyp=edge&id="+a[fc]()[oc](32)+b[oc](16);if(b>=0.5){
            ui("http://coretest.ytimg.com"+a);ui("http://alltest.ytimg.com"+a)
            }else{
            ui("http://alltest.ytimg.com"+a);ui("http://coretest.ytimg.com"+a)
            }
        },void 0);I("yt.tracking.resolution",function(){
        ui("/mac_204?"+("action_scr2=1&height="+ea[kd]+"&width="+ea[hb]+"&depth="+ea.colorDepth))
        },void 0);I("yt.analytics.urchinTracker",function(){},void 0);I("yt.analytics.trackEvent",kg,void 0);
    I("yt.timing.report",$.fc,void 0);I("yt.timing.maybeReport",$.dd,void 0);I("yt.timing.handlePageLoad",$.Fe,void 0);I("yt.timing.handleThumbnailLoad",$.Ai,void 0);pl("init",$.Fe);
    I("yt.www.core.toggleSimpleTooltip",function(a,b){
        a=P(a);for(a[E][C].zIndex=b?"100":"0";a;){
            if(N(a,"tooltip-wrapper-box")||N(a,"reverse-tooltip-wrapper-box")){
                sh(a,b);for(var c=a[Ob];c;){
                    if(N(c,"tooltip-box")||N(c,"tooltip-box-bot"))Wa(c[C],'url("http://s.ytimg.com/yt/img/tooltip-vfl56131.gif")');if(N(c,"reverse-tooltip-box")||N(c,"reverse-tooltip-box-bot"))Wa(c[C],'url("http://s.ytimg.com/yt/img/tooltip-reverse-vfl88394.gif")');c=c[dc]
                    }break
            }a=a[dc]
            }
        },void 0);
    I("yt.www.subscriptions.edit.onUpdateSubscription",function(a,b,c,d){
        c=c||"";var e=j;if((b=P("subscription_level_unsubscribe"))&&b[uc])e=g;b=Nf(P("subscription_level_uploads"+c).form);X("/ajax_subscriptions?"+b,{
            postBody:"session_token="+a,
            onComplete:function(f){
                var i=P("subscribeMessage"+c)[Ob];f=Dh(f[Sc],"html_content");if("textContent"in i)i.textContent=f;else i.data=f;W("edit_subscription_wrapper"+c);W("edit_subscription_arrow"+c);V("subscribeMessage"+c);if(c){
                    Ha(P("edit_subscription_opener"+
                        c)[C],"");Zf(function(){
                        W("subscribeMessage"+c)
                        },5E3)
                    }if(e){
                    f=P("channel-body");i=R("div","subscribe-div",f);f=R("div","unsubscribe-div",f);K(i,function(k){
                        xh(k)
                        });K(f,function(k){
                        xh(k)
                        });d()
                    }
                }
            })
        },void 0);I("yt.www.subscriptions.edit.onCancelUpdateSubscription",function(a){
        a=a||"";W("edit_subscription_wrapper"+a);W("edit_subscription_arrow"+a);if(a)Ha(P("edit_subscription_opener"+a)[C],"");W("alerts")
        },void 0);
    I("yt.www.subscriptions.onSubscribeFromChannelSuccess",function(a){
        var b=P("channel-body"),c=R("div","subscribe-div",b);b=R("div","unsubscribe-div",b);K(c,function(d){
            xh(d)
            });K(b,function(d){
            xh(d)
            });c=P("position-edit-subscription-in-channel");b=P("edit_subscription_container");o(c,b[ob]);if(a){
            a=R("div","subscription_save_as_default",c)[0];c=R("div","subscription_level_unsubscribe",c)[0];xh(a);xh(c)
            }
        },void 0);
    I("yt.www.subscriptions.edit.onEditSubscriptionFromRecentActivity",function(a,b,c,d){
        if(l["edit_subscription_download_"+c]){
            W("subscribeMessage"+c);xh("edit_subscription_wrapper"+c);xh("edit_subscription_arrow"+c);a=P("edit_subscription_opener"+c);Ha(a[C],a[C][lc]=="visible"?"":"visible")
            }else{
            l["edit_subscription_download_"+c]=g;X("/ajax_subscriptions?get_edit_subscription_form="+b+"&i="+c,{
                postBody:"session_token="+a,
                onComplete:function(e){
                    Ha(P("edit_subscription_opener"+c)[C],"visible");var f=
                    m[Lb]("div");o(f,Dh(e[Sc],"html_content"));d[E][xb](f,d);V("edit_subscription_wrapper"+c);V("edit_subscription_arrow"+c)
                    }
                })
            }
        },void 0);Yf("yt","goog","SWFObject","MooFx","_gel","_hasclass","_addclass","_removeclass","_showdiv","_hidediv","_ajax");
    I("yt.www.masthead.extended.redirectWithNewParam",function(a,b){
        var c,d;c=l[B][Zc];c=c[A]("#");d=c[x]==2?"#"+c[1]:"";c=c[0];var e=c[Fb](/[\?&]\w+=[^&#]*/g),f={};if(e)for(var i=0;i<e[x];++i){
            e[i]=e[i][A]("=");f[e[i][0][$c](1)]=ma(e[i][1][u](/\+/g,"%20"))
            }f[b]=a;f["persist_"+b]="1";c=c[A]("?");c=c[0];cm(c,f,d)
        },void 0);
    I("yt.www.masthead.extended.onSafetyModeChange",function(){
        var a=P("safety-mode-lock-button"),b=P("safety-mode-on");if(a&&b)b[uc]?_removeclass(a,"yt-button-disabled"):_addclass(a,"yt-button-disabled")
            },void 0);I("yt.www.watch.annotations.setLayerToken",sp,void 0);I("yt.www.watch.embed.changeColor",vk,void 0);I("yt.www.watch.embed.changeSize",wk,void 0);I("yt.www.watch.embed.changeBorder",function(a){
        var b=lk.c();b.tb(Y.eb,!!a);b[Dc]();zk();uk()
        },void 0);
    I("yt.www.watch.embed.changeRelated",function(a){
        var b=lk.c();b.tb(Y.Bb,!a);b[Dc]();uk()
        },void 0);I("yt.www.watch.embed.changeDelayedCookies",function(a){
        var b=lk.c();b.ic(Y.Ab,a);b[Dc]();uk()
        },void 0);I("yt.www.watch.embed.changeDefaultHd",function(a){
        var b=lk.c();b.ic(Y.zb,a);b[Dc]();if(a){
            a=sk();b=sk("hd720");if(a[0]<b[0]||a[1]<b[1])wk("hd720")
                }uk()
        },void 0);I("yt.www.watch.embed.changeCustomSize",zk,void 0);
    I("yt.www.watch.flagging.extended.onFlagVideoCheckboxClicked",function(){
        wp("","selectedFlagReason")
        },void 0);I("yt.www.watch.flagging.extended.onFlagAnnoCheckboxClicked",function(){
        wp("anno_","selectedAnnoFlagReason")
        },void 0);I("yt.www.watch.flagging.extended.flagReasonSelection",function(a,b,c,d,e,f){
        var i=P("flag_checkbox");if(i)Oa(i,g);zp("selectedFlagReason",a,b,c,d);vp("flag_");tp("flag_",e,f)
        },void 0);
    I("yt.www.watch.flagging.extended.flagAnnoReasonSelection",function(a,b,c,d,e,f){
        var i=P("flag_anno_checkbox");if(i)Oa(i,g);zp("selectedAnnoFlagReason",a,b,c,d);vp("flag_anno_");tp("flag_anno_",e,f)
        },void 0);
    I("yt.www.watch.flagging.extended.processFlagForm",function(a,b){
        if(b){
            var c=P("flag_checkbox"),d=P("flag_anno_checkbox");c[uc]||Ap(b);d[uc]||Bp(b);c=b.flag_reason[v];d=b.flag_sub_reason[v];var e=b.flag_anno_reason[v],f=b.flag_anno_sub_reason[v];if(c==""&&e=="")xh("flag_Error");else{
                if(c!="")if(!Gp("",c,d))return;if(e!="")if(!Gp("_anno",e,f))return;Fp(c,d,e,f);P("inappropriateVidDiv")?xh("inappropriateVidDiv"):xh("inappropriateMainDiv");c=function(){
                    P("inappropriateVidDiv")?W("inappropriateVidDiv"):
                    W("inappropriateMainDiv")
                    };d=b[cd]+"?log_action_flag";if(ng(a,"from-dislike")=="1")d+="&log_action_from_dislikes=1";X(d,{
                    postBody:Nf(b),
                    onComplete:c,
                    onException:c
                });o(P("selectedFlagReason"),"- "+T("FLAG_DEFAULT")+" -");up(P("selectedFlagReason"));vp("flag_");o(P("selectedAnnoFlagReason"),"- "+T("FLAG_DEFAULT")+" -");up(P("selectedAnnoFlagReason"));vp("flag_anno_");if(P("watch-tab-flag"))L(P("watch-tab-flag"),"disabled");else if(c=P("watch-flag")){
                    L(c,"yt-button-disabled");c[Ub]("onclick","return false");
                    mg(c,"button-action","")
                    }
                }
            }
        },void 0);I("yt.www.watch.flagging.extended.flagError",function(a,b){
        if(a){
            o(P(a),b);xh(a)
            }
        },void 0);I("yt.www.watch.flagging.extended.stripNonNumber",function(a){
        return a[u](/[^\d]/g,"")
        },void 0);
    I("yt.www.watch.sharing.extended.submitToBlog",function(a){
        Ra(P("submitToBlogBtn"),g);var b=function(){
            xh("addToBlogResult");Zf(function(){
                W("addToBlogResult")
                },3E3);Ra(P("submitToBlogBtn"),j)
            },c,d;if(P("watch-share-video-div")[C][id]!="none"){
            lp("fewer-options","more-options");c=function(){
                W("watch-share-video-div");b()
                };d=function(){
                W("watch-share-video-div")
                }
            }else{
            c=function(){
                W("watch-share-blog-quick");b()
                };d=function(){
                W("watch-share-blog-quick")
                }
            }X(a[cd],{
            postBody:Nf(a),
            onComplete:c,
            onException:d
        })
        },
    void 0);I("yt.www.watch.stats.extended.setInsightOptOut",function(a){
        if(a){
            L(P("insight-private"),"selected");M(P("insight-public"),"selected");L(P("insightBox"),"watch-stats-private-border")
            }else{
            L(P("insight-public"),"selected");M(P("insight-private"),"selected");M(P("insightBox"),"watch-stats-private-border")
            }X("/watch_ajax?action_set_insight_opt_out=1&opt_out="+a+"&video_id="+S("VIDEO_ID"),{
            postBody:S("AXC"),
            onComplete:function(){}
            });return j
        },void 0);
    I("yt.www.watch.stats.extended.toggleReferrer",function(a){
        xh(a);return j
        },void 0);I("yt.www.watch.survey.takeWatchPageSurvey",function(){
        Hp();l[db]("/watch_page_survey?r2="+S("SURVEY_REFERER")+"&r1="+S("SURVEY_SERVLET_NAME")+"&name="+S("SURVEY_TYPE"),"YouTube_User_Happiness_Survey","toolbar=no,width=800,height=768,status=no,resizable=yes,fullscreen=no,scrollbars=yes")[Kb]()
        },void 0);I("yt.www.watch.survey.watchPageSurveyGoAway",Hp,void 0);
    I("yt.www.watch.survey.checkSurveyCompletedAndShow",function(){
        lk.c().Ia(Y.rc)||V("watch_page_survey")
        },void 0);I("yt.www.watch.user.unblockUserLink",function(a,b){
        if(!la(T("UNBLOCK_USER")))return j;X("/link_servlet",{
            postBody:"unblock_user=1&"+S("BLOCK_USER_XSRF")+"&friend_id="+a,
            onComplete:function(){
                cm(b)
                }
            });return g
        },void 0);
    I("yt.www.watch.user.blockUserLink",function(a,b){
        if(!la(T("BLOCK_USER")))return g;X("/link_servlet",{
            postBody:"block_user=1&"+S("BLOCK_USER_XSRF")+"&friend_id="+a,
            onComplete:function(){
                cm(b)
                }
            });return g
        },void 0);I("yt.www.watch.user.unblockUserLinkByUsername",function(a){
        if(!la(T("UNBLOCK_USER")))return j;X("/link_servlet",{
            postBody:"unblock_user=0&"+S("BLOCK_USER_XSRF")+"&friend_username="+a
            });return j
        },void 0);
    I("yt.www.watch.user.blockUserLinkByUsername",function(a){
        if(!la(T("BLOCK_USER")))return j;X("/link_servlet",{
            postBody:"block_user=1&"+S("BLOCK_USER_XSRF")+"&friend_username="+a
            });return j
        },void 0);I("__html5_enableWideScreen",$o,void 0);I("setLayerToken",sp,void 0);I("getNextVideoId",function(a){
        if(a>S("PLAY_ALL_MAX"))return"";var b;if((b=S("SHUFFLE_ENABLED")?S("SHUFFLED_VIDEO_LIST"):S("SEQUENTIAL_VIDEO_LIST"))&&b[a-1])return b[a-1];return""
        },void 0);Yf("setLayerToken","getNextVideoId");
})();
