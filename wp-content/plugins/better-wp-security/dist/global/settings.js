this.itsec=this.itsec||{},this.itsec.global=this.itsec.global||{},this.itsec.global.settings=(window.itsecWebpackJsonP=window.itsecWebpackJsonP||[]).push([[17],{"1ZqX":function(t,e){!function(){t.exports=this.wp.data}()},GRId:function(t,e){!function(){t.exports=this.wp.element}()},K9lf:function(t,e){!function(){t.exports=this.wp.compose}()},Mmq9:function(t,e){!function(){t.exports=this.wp.url}()},RxS6:function(t,e){!function(){t.exports=this.wp.keycodes}()},Tqx9:function(t,e){!function(){t.exports=this.wp.primitives}()},TvNi:function(t,e){!function(){t.exports=this.wp.plugins}()},YLtl:function(t,e){!function(){t.exports=this.lodash}()},cDcd:function(t,e){!function(){t.exports=this.React}()},faye:function(t,e){!function(){t.exports=this.ReactDOM}()},gdqT:function(t,e){!function(){t.exports=this.wp.a11y}()},"hDn/":function(t,e,n){},l3Sj:function(t,e){!function(){t.exports=this.wp.i18n}()},rl8x:function(t,e){!function(){t.exports=this.wp.isShallowEqual}()},"tI+e":function(t,e){!function(){t.exports=this.wp.components}()},wM5K:function(t,e,n){"use strict";n.r(e);var c=n("GRId"),i=n("l3Sj"),o=n("TvNi"),s=n("RIqP"),r=n.n(s),a=n("tI+e"),l=n("ywyh"),u=n.n(l),p=n("1ZqX"),b=n("tMTs"),f=n("ppSj"),h=n("oYJ/");n("hDn/");function d(t){var e=t.label,n=t.detectIp;return Object(c.createElement)("div",{className:"itsec-global-detected-ip"},Object(c.createElement)(a.Button,{isSecondary:!0,onClick:n},Object(i.__)("Check IP","better-wp-security")),Object(c.createElement)("span",null,e))}function g(t){var e=t.value,n=t.onChange,o=t.ip;return Object(c.createElement)(a.Button,{isSecondary:!0,onClick:function(){n([].concat(r()(e),[o]))},disabled:!o,className:"itsec-global-add-authorized-ip"},Object(i.__)("Add my current IP to the authorized hosts list","better-wp-security"))}function m(){var t=function(){var t,e=Object(p.useSelect)((function(t){return{proxy:t(h.c).getEditedSetting("global","proxy"),proxyHeader:t(h.c).getEditedSetting("global","proxy_header"),schema:t(h.c).getSettingSchema("global","proxy")}})),n=e.proxy,o=e.proxyHeader,s=e.schema,r=Object(c.useCallback)((function(){var t={proxy:s.enum.includes(n)?n:s.default};return"manual"===t.proxy&&(t.args={header:o}),u()({method:"POST",path:"ithemes-security/rpc/global/detect-ip",data:t})}),[n,o,s]),a=Object(f.a)(r,!!n&&!!s),l=a.execute,b=a.status,d=a.value,g=a.error;switch(b){case"idle":break;case"pending":t=Object(i.__)("Detecting IP","better-wp-security");break;case"success":t=Object(i.sprintf)(Object(i.__)("Detected IP: %s","better-wp-security"),d.ip);break;case"error":t=Object(i.sprintf)(Object(i.__)("Error detecting IP: %s","better-wp-security"),g.message||Object(i.__)("Unknown error."))}return{label:t,detectIp:l,ip:null==d?void 0:d.ip}}(),e=t.label,n=t.detectIp,o=t.ip;return Object(c.createElement)(React.Fragment,null,Object(c.createElement)(b.a,{name:"itsec_global_lockout_white_list"},(function(t){var e=t.formData,n=t.onChange;return Object(c.createElement)(g,{value:e,onChange:n,ip:o})})),Object(c.createElement)(b.a,{name:"itsec_global_proxy"},(function(){return Object(c.createElement)(d,{label:e,detectIp:n})})))}n.p=window.itsecWebpackPublicPath,Object(i.setLocaleData)({"":{}},"ithemes-security-pro"),Object(o.registerPlugin)("itsec-global-settings",{render:function(){return Object(c.createElement)(m,null)}})},ywyh:function(t,e){!function(){t.exports=this.wp.apiFetch}()}},[["wM5K",0,5,1,4,2,3]]]);