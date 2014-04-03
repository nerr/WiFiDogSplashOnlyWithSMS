$(document).ready(function ()
{

    var BrowserSpy =
    {
        init: function ()
        {
            this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
            this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "an unknown version";
            this.OS = this.searchString(this.dataOS) || "an unknown OS";
            this.cookies = navigator.cookieEnabled;
            this.language = (this.browser === "Explorer" ? navigator.userLanguage : navigator.language);
            this.colors = window.screen.colorDepth;
            this.browserWidth = window.screen.width;
            this.browserHeight = window.screen.height;
            this.java = (navigator.javaEnabled() == 1 ? true : false);
            this.codeName = navigator.appCodeName;
            this.cpu = navigator.oscpu;
            this.useragent = navigator.userAgent;
            this.plugins = navigator.plugins;
            this.ipAddress();
        },
        searchString: function (data)
        {
            for (var i = 0; i < data.length; i++)
            {
                var dataString = data[i].string;
                var dataProp = data[i].prop;
                this.versionSearchString = data[i].versionSearch || data[i].identity;
                if (dataString)
                {
                    if (dataString.indexOf(data[i].subString) != -1) return data[i].identity;
                }
                else if (dataProp) return data[i].identity;
            }
        },
        searchVersion: function (dataString)
        {
            var index = dataString.indexOf(this.versionSearchString);
            if (index == -1) return;
            return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
        },

        ipAddress: function ()
        {
/*
            if (navigator.javaEnabled() && (navigator.appName != "Microsoft Internet Explorer"))
            {
                vartool = java.awt.Toolkit.getDefaultToolkit();
                addr = java.net.InetAddress.getLocalHost();
                this.host = addr.getHostName();
                this.ip = addr.getHostAddress();
            }
            else
            {
                this.host = false;;
                this.ip = false;
            }*/

            this.ip = false;

        },

        screenSize: function ()
        {
            var myWidth = 0,
                myHeight = 0;
            if (typeof(window.innerWidth) == 'number')
            {
                //Non-IE
                this.browserWidth = window.innerWidth;
                this.browserHeight = window.innerHeight;
            }
            else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight))
            {
                //IE 6+ in 'standards compliant mode'
                this.browserWidth = document.documentElement.clientWidth;
                this.browserHeight = document.documentElement.clientHeight;
            }
            else if (document.body && (document.body.clientWidth || document.body.clientHeight))
            {
                //IE 4 compatible
                this.browserWidth = document.body.clientWidth;
                this.browserHeight = document.body.clientHeight;
            }
        },
        dataBrowser: [
        {
            string: navigator.userAgent,
            subString: "Chrome",
            identity: "Chrome"
        }, {
            string: navigator.userAgent,
            subString: "OmniWeb",
            versionSearch: "OmniWeb/",
            identity: "OmniWeb"
        }, {
            string: navigator.vendor,
            subString: "Apple",
            identity: "Safari",
            versionSearch: "Version"
        }, {
            prop: window.opera,
            identity: "Opera"
        }, {
            string: navigator.vendor,
            subString: "iCab",
            identity: "iCab"
        }, {
            string: navigator.vendor,
            subString: "KDE",
            identity: "Konqueror"
        }, {
            string: navigator.userAgent,
            subString: "Firefox",
            identity: "Firefox"
        }, {
            string: navigator.vendor,
            subString: "Camino",
            identity: "Camino"
        }, { // for newer Netscapes (6+)
            string: navigator.userAgent,
            subString: "Netscape",
            identity: "Netscape"
        }, {
            string: navigator.userAgent,
            subString: "MSIE",
            identity: "Explorer",
            versionSearch: "MSIE"
        }, {
            string: navigator.userAgent,
            subString: "Gecko",
            identity: "Mozilla",
            versionSearch: "rv"
        }, { // for older Netscapes (4-)
            string: navigator.userAgent,
            subString: "Mozilla",
            identity: "Netscape",
            versionSearch: "Mozilla"
        }],
        dataOS: [
        {
            string: navigator.platform,
            subString: "Win",
            identity: "Windows"
        }, {
            string: navigator.platform,
            subString: "Mac",
            identity: "Mac"
        }, {
            string: navigator.userAgent,
            subString: "iPhone",
            identity: "iPhone/iPod"
        }, {
            string: navigator.platform,
            subString: "Linux",
            identity: "Linux"
        }]

    };

    BrowserSpy.init();

    $.client =
    {
        os: BrowserSpy.OS,
        browser: BrowserSpy.browser,
        version: BrowserSpy.version,
        cookies: BrowserSpy.cookies,
        language: BrowserSpy.language,
        browserWidth: BrowserSpy.browserWidth,
        browserHeight: BrowserSpy.browserHeight,
        java: BrowserSpy.java,
        colors: BrowserSpy.colors,
        codeName: BrowserSpy.codeName,
        host: BrowserSpy.host,
        ip: BrowserSpy.ip,
        cpu: BrowserSpy.cpu,
        useragent: BrowserSpy.useragent,
        //plugins: BrowserSpy.plugins
    };

})
