!function(){"use strict";var e,t={937:function(){var e=window.wp.element,t=window.wp.blocks,n=window.wp.blockEditor,r=window.wp.components,o=window.wp.i18n;(0,t.registerBlockType)("motopress-hotel-booking/wrapper",{edit:t=>{const{attributes:i,setAttributes:l}=t,s=(0,n.useBlockProps)({style:{maxWidth:i.maxWidth+"px"}});return(0,e.createElement)("div",s,(0,e.createElement)(n.InspectorControls,null,(0,e.createElement)(r.PanelBody,{title:(0,o.__)("Settings","mphb-styles")},(0,e.createElement)(r.TextControl,{type:"number",label:(0,o.__)("Wrapper width(in pixels)","mphb-styles"),value:i.maxWidth,onChange:e=>l({maxWidth:e})}))),(0,e.createElement)(n.InnerBlocks,null))},save:t=>{const r=n.useBlockProps.save({style:{maxWidth:t.attributes.maxWidth+"px"}});return(0,e.createElement)("div",r,(0,e.createElement)(n.InnerBlocks.Content,null))}})}},n={};function r(e){var o=n[e];if(void 0!==o)return o.exports;var i=n[e]={exports:{}};return t[e](i,i.exports,r),i.exports}r.m=t,e=[],r.O=function(t,n,o,i){if(!n){var l=1/0;for(c=0;c<e.length;c++){n=e[c][0],o=e[c][1],i=e[c][2];for(var s=!0,a=0;a<n.length;a++)(!1&i||l>=i)&&Object.keys(r.O).every((function(e){return r.O[e](n[a])}))?n.splice(a--,1):(s=!1,i<l&&(l=i));if(s){e.splice(c--,1);var u=o();void 0!==u&&(t=u)}}return t}i=i||0;for(var c=e.length;c>0&&e[c-1][2]>i;c--)e[c]=e[c-1];e[c]=[n,o,i]},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={536:0,743:0};r.O.j=function(t){return 0===e[t]};var t=function(t,n){var o,i,l=n[0],s=n[1],a=n[2],u=0;if(l.some((function(t){return 0!==e[t]}))){for(o in s)r.o(s,o)&&(r.m[o]=s[o]);if(a)var c=a(r)}for(t&&t(n);u<l.length;u++)i=l[u],r.o(e,i)&&e[i]&&e[i][0](),e[i]=0;return r.O(c)},n=self.webpackChunkmphb_templates=self.webpackChunkmphb_templates||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))}();var o=r.O(void 0,[743],(function(){return r(937)}));o=r.O(o)}();