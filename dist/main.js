!function(e){var a={};function n(t){if(a[t])return a[t].exports;var o=a[t]={i:t,l:!1,exports:{}};return e[t].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=a,n.d=function(e,a,t){n.o(e,a)||Object.defineProperty(e,a,{enumerable:!0,get:t})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,a){if(1&a&&(e=n(e)),8&a)return e;if(4&a&&"object"==typeof e&&e&&e.__esModule)return e;var t=Object.create(null);if(n.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:e}),2&a&&"string"!=typeof e)for(var o in e)n.d(t,o,function(a){return e[a]}.bind(null,o));return t},n.n=function(e){var a=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(a,"a",a),a},n.o=function(e,a){return Object.prototype.hasOwnProperty.call(e,a)},n.p="",n(n.s=0)}([function(e,a,n){"use strict";
/*!

=========================================================
* Argon Dashboard - v1.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2020 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md)

* Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/var t,o,i,r,s,d,l,c,u,g,p,v;(function(){function e(){$(".sidenav-toggler").addClass("active"),$(".sidenav-toggler").data("action","sidenav-unpin"),$("body").removeClass("g-sidenav-hidden").addClass("g-sidenav-show g-sidenav-pinned"),$("body").append('<div class="backdrop d-xl-none" data-action="sidenav-unpin" data-target='+$("#sidenav-main").data("target")+" />"),Cookies.set("sidenav-state","pinned")}function a(){$(".sidenav-toggler").removeClass("active"),$(".sidenav-toggler").data("action","sidenav-pin"),$("body").removeClass("g-sidenav-pinned").addClass("g-sidenav-hidden"),$("body").find(".backdrop").remove(),Cookies.set("sidenav-state","unpinned")}var n=Cookies.get("sidenav-state")?Cookies.get("sidenav-state"):"pinned";$(window).width()>1200&&("pinned"==n&&e(),"unpinned"==Cookies.get("sidenav-state")&&a(),$(window).resize((function(){$("body").hasClass("g-sidenav-show")&&!$("body").hasClass("g-sidenav-pinned")&&$("body").removeClass("g-sidenav-show").addClass("g-sidenav-hidden")}))),$(window).width()<1200&&($("body").removeClass("g-sidenav-hide").addClass("g-sidenav-hidden"),$("body").removeClass("g-sidenav-show"),$(window).resize((function(){$("body").hasClass("g-sidenav-show")&&!$("body").hasClass("g-sidenav-pinned")&&$("body").removeClass("g-sidenav-show").addClass("g-sidenav-hidden")}))),$("body").on("click","[data-action]",(function(n){n.preventDefault();var t=$(this),o=t.data("action");t.data("target");switch(o){case"sidenav-pin":e();break;case"sidenav-unpin":a();break;case"search-show":t.data("target"),$("body").removeClass("g-navbar-search-show").addClass("g-navbar-search-showing"),setTimeout((function(){$("body").removeClass("g-navbar-search-showing").addClass("g-navbar-search-show")}),150),setTimeout((function(){$("body").addClass("g-navbar-search-shown")}),300);break;case"search-close":t.data("target"),$("body").removeClass("g-navbar-search-shown"),setTimeout((function(){$("body").removeClass("g-navbar-search-show").addClass("g-navbar-search-hiding")}),150),setTimeout((function(){$("body").removeClass("g-navbar-search-hiding").addClass("g-navbar-search-hidden")}),300),setTimeout((function(){$("body").removeClass("g-navbar-search-hidden")}),500)}})),$(".sidenav").on("mouseenter",(function(){$("body").hasClass("g-sidenav-pinned")||$("body").removeClass("g-sidenav-hide").removeClass("g-sidenav-hidden").addClass("g-sidenav-show")})),$(".sidenav").on("mouseleave",(function(){$("body").hasClass("g-sidenav-pinned")||($("body").removeClass("g-sidenav-show").addClass("g-sidenav-hide"),setTimeout((function(){$("body").removeClass("g-sidenav-hide").addClass("g-sidenav-hidden")}),300))})),$(window).on("load resize",(function(){$("body").height()<800&&($("body").css("min-height","100vh"),$("#footer-main").addClass("footer-auto-bottom"))}))})(),function(){var e,a=$('[data-toggle="chart"]'),n="light",t={base:"Open Sans"},o={gray:{100:"#f6f9fc",200:"#e9ecef",300:"#dee2e6",400:"#ced4da",500:"#adb5bd",600:"#8898aa",700:"#525f7f",800:"#32325d",900:"#212529"},theme:{default:"#172b4d",primary:"#5e72e4",secondary:"#f4f5f7",info:"#11cdef",success:"#2dce89",danger:"#f5365c",warning:"#fb6340"},black:"#12263F",white:"#FFFFFF",transparent:"transparent"};function i(e,a){for(var n in a)"object"!=typeof a[n]?e[n]=a[n]:i(e[n],a[n])}function r(e){var a=e.data("add"),n=$(e.data("target")),t=n.data("chart");t||(t=n.data("chart2")),e.is(":checked")?(!function e(a,n){for(var t in n)Array.isArray(n[t])?n[t].forEach((function(e){a[t].push(e)})):e(a[t],n[t])}(t,a),t.update()):(!function e(a,n){for(var t in n)Array.isArray(n[t])?n[t].forEach((function(e){a[t].pop()})):e(a[t],n[t])}(t,a),t.update())}function s(e){var a=e.data("update"),n=$(e.data("target")),t=n.data("chart");t||(t=n.data("chart2")),i(t,a),function(e,a){if(void 0!==e.data("prefix")||void 0!==e.data("prefix")){var n=e.data("prefix")?e.data("prefix"):"",t=e.data("suffix")?e.data("suffix"):"";a.options.scales.yAxes[0].ticks.callback=function(e){if(!(e%10))return n+e+t},a.options.tooltips.callbacks.label=function(e,a){var o=a.datasets[e.datasetIndex].label||"",i=e.yLabel,r="";return a.datasets.length>1&&(r+='<span class="popover-body-label mr-auto">'+o+"</span>"),r+='<span class="popover-body-value">'+n+i+t+"</span>"}}}(e,t),t.update()}window.Chart&&i(Chart,(e={defaults:{global:{responsive:!0,maintainAspectRatio:!1,defaultColor:o.gray[600],defaultFontColor:o.gray[600],defaultFontFamily:t.base,defaultFontSize:13,layout:{padding:0},legend:{display:!1,position:"bottom",labels:{usePointStyle:!0,padding:16}},elements:{point:{radius:0,backgroundColor:o.theme.primary},line:{tension:.4,borderWidth:4,borderColor:o.theme.primary,backgroundColor:o.transparent,borderCapStyle:"rounded"},rectangle:{backgroundColor:o.theme.warning},arc:{backgroundColor:o.theme.primary,borderColor:o.white,borderWidth:4}},tooltips:{enabled:!0,mode:"index",intersect:!1}},doughnut:{cutoutPercentage:83,legendCallback:function(e){var a=e.data,n="";return a.labels.forEach((function(e,t){var o=a.datasets[0].backgroundColor[t];n+='<span class="chart-legend-item">',n+='<i class="chart-legend-indicator" style="background-color: '+o+'"></i>',n+=e,n+="</span>"})),n}}}},Chart.scaleService.updateScaleDefaults("linear",{gridLines:{borderDash:[2],borderDashOffset:[2],color:o.gray[300],drawBorder:!1,drawTicks:!1,drawOnChartArea:!0,zeroLineWidth:0,zeroLineColor:"rgba(0,0,0,0)",zeroLineBorderDash:[2],zeroLineBorderDashOffset:[2]},ticks:{beginAtZero:!0,padding:10,callback:function(e){if(!(e%10))return e}}}),Chart.scaleService.updateScaleDefaults("category",{gridLines:{drawBorder:!1,drawOnChartArea:!1,drawTicks:!1},ticks:{padding:20},maxBarThickness:10}),e)),a.on({change:function(){var e=$(this);e.is("[data-add]")&&r(e)},click:function(){var e=$(this);e.is("[data-update]")&&s(e)}})}(),(o=$(".btn-icon-clipboard")).length&&((t=o).tooltip().on("mouseleave",(function(){t.tooltip("hide")})),new ClipboardJS(".btn-icon-clipboard").on("success",(function(e){$(e.trigger).attr("title","Copied!").tooltip("_fixTitle").tooltip("show").attr("title","Copy to clipboard").tooltip("_fixTitle"),e.clearSelection()}))),i=$(".navbar-nav, .navbar-nav .nav"),r=$(".navbar .collapse"),s=$(".navbar .dropdown"),r.on({"show.bs.collapse":function(){!function(e){e.closest(i).find(r).not(e).collapse("hide")}($(this))}}),s.on({"hide.bs.dropdown":function(){!function(e){var a=e.find(".dropdown-menu");a.addClass("close"),setTimeout((function(){a.removeClass("close")}),200)}($(this))}}),function(){$(".navbar-nav");var e=$(".navbar .navbar-custom-collapse");e.length&&(e.on({"hide.bs.collapse":function(){!function(e){e.addClass("collapsing-out")}(e)}}),e.on({"hidden.bs.collapse":function(){!function(e){e.removeClass("collapsing-out")}(e)}}));var a=0;$(".sidenav-toggler").click((function(){if(1==a)$("body").removeClass("nav-open"),a=0,$(".bodyClick").remove();else{$('<div class="bodyClick"></div>').appendTo("body").click((function(){$("body").removeClass("nav-open"),a=0,$(".bodyClick").remove()})),$("body").addClass("nav-open"),a=1}}))}(),d=$('[data-toggle="popover"]'),l="",d.length&&d.each((function(){!function(e){e.data("color")&&(l="popover-"+e.data("color"));var a={trigger:"focus",template:'<div class="popover '+l+'" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'};e.popover(a)}($(this))})),function(){var e=$(".scroll-me, [data-scroll-to], .toc-entry a");function a(e){var a=e.attr("href"),n=e.data("scroll-to-offset")?e.data("scroll-to-offset"):0,t={scrollTop:$(a).offset().top-n};$("html, body").stop(!0,!0).animate(t,600),event.preventDefault()}e.length&&e.on("click",(function(e){a($(this))}))}(),(c=$('[data-toggle="tooltip"]')).length&&c.tooltip(),(u=$(".form-control")).length&&function(e){e.on("focus blur",(function(e){$(this).parents(".form-group").toggleClass("focused","focus"===e.type)})).trigger("blur")}(u);$("#map-default").length&&google.maps.event.addDomListener(window,"load",(function(){g=document.getElementById("map-default"),p=g.getAttribute("data-lat"),v=g.getAttribute("data-lng");var e=new google.maps.LatLng(p,v),a={zoom:12,scrollwheel:!1,center:e,mapTypeId:google.maps.MapTypeId.ROADMAP};g=new google.maps.Map(g,a);var n=new google.maps.Marker({position:e,map:g,animation:google.maps.Animation.DROP,title:"Hello World!"}),t=new google.maps.InfoWindow({content:'<div class="info-window-content"><h2>Argon Dashboard</h2><p>A beautiful Dashboard for Bootstrap 4. It is Free and Open Source.</p></div>'});google.maps.event.addListener(n,"click",(function(){t.open(g,n)}))}));(f=$(".datepicker")).length&&f.each((function(){!function(e){e.datepicker({disableTouchKeyboard:!0,autoclose:!1})}($(this))}));var f,h,b=function(){if($(".input-slider-container")[0]&&$(".input-slider-container").each((function(){var e=$(this).find(".input-slider"),a=e.attr("id"),n=e.data("range-value-min"),t=e.data("range-value-max"),o=$(this).find(".range-slider-value"),i=o.attr("id"),r=o.data("range-value-low"),s=document.getElementById(a),d=document.getElementById(i);b.create(s,{start:[parseInt(r)],connect:[!0,!1],range:{min:[parseInt(n)],max:[parseInt(t)]}}),s.noUiSlider.on("update",(function(e,a){d.textContent=e[a]}))})),$("#input-slider-range")[0]){var e=document.getElementById("input-slider-range"),a=document.getElementById("input-slider-range-value-low"),n=document.getElementById("input-slider-range-value-high"),t=[a,n];b.create(e,{start:[parseInt(a.getAttribute("data-range-value-low")),parseInt(n.getAttribute("data-range-value-high"))],connect:!0,range:{min:parseInt(e.getAttribute("data-range-value-min")),max:parseInt(e.getAttribute("data-range-value-max"))}}),e.noUiSlider.on("update",(function(e,a){t[a].textContent=e[a]}))}}();(h=$(".scrollbar-inner")).length&&h.scrollbar().scrollLock()}]);