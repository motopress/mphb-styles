!function(){"use strict";var e={n:function(t){var o=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(o,{a:o}),o},d:function(t,o){for(var n in o)e.o(o,n)&&!e.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:o[n]})},o:function(e,t){return Object.prototype.hasOwnProperty.call(e,t)}},t=window.wp.element,o=window.wp.blocks,n=window.wp.blockEditor,l=window.wp.data,r=window.wp.components,i=window.wp.i18n,a=window.wp.serverSideRender,s=e.n(a),d=e=>{let o=(0,l.useSelect)((e=>{var t;let o=e("core").getEntityRecords("postType","mphb_room_type");return o=null===(t=o)||void 0===t?void 0:t.map((e=>({label:e.title.raw+" #"+e.id.toString(),value:e.id.toString()}))),o}),[]);return o||(o=[]),(0,t.createElement)(r.ComboboxControl,{label:(0,i.__)("Accommodation Type","mphb-styles"),value:e.value,options:o,onChange:e.onChange,help:(0,i.__)("Leave blank to use current.","mphb-styles"),disabled:!o})};(0,o.registerBlockType)("motopress-hotel-booking/featured-image",{edit:e=>{const o=(0,n.useBlockProps)(),{attributes:a,setAttributes:c}=e,u=(0,l.useSelect)((e=>{var t;let o=a.id?a.id:e("core/editor").getCurrentPostId();const n=e("core").getEntityRecord("postType","mphb_room_type",o),l=null===(t=e("core").getMedia(null==n?void 0:n.featured_media))||void 0===t?void 0:t.media_details.sizes,r=e("core/block-editor").getSettings().imageSizes;let s=[{value:"",label:(0,i.__)("Default","mphb-styles")}];return l&&Object.entries(l).forEach((e=>{let[t,o]=e,n=r.find((e=>e.slug==t));s.push({value:t,label:n?null==n?void 0:n.name:t})})),s}),[]);return(0,t.createElement)("div",o,(0,t.createElement)(n.InspectorControls,null,(0,t.createElement)(r.PanelBody,{title:(0,i.__)("Settings","mphb-styles")},(0,t.createElement)(d,{value:a.id,onChange:e=>{c({id:e})}}),(0,t.createElement)(r.ToggleControl,{label:(0,i.__)("Link to post","mphb-styles"),checked:a.linkToPost,onChange:e=>c({linkToPost:e})}),(0,t.createElement)(r.SelectControl,{label:(0,i.__)("Image size","mphb-styles"),value:a.size,options:u,onChange:e=>{c({size:e})}}))),!a.id&&(0,t.createElement)(Placeholder,{label:(0,i.__)("Accommodation Type Image","mphb-styles"),icon:"admin-home"}),a.id&&(0,t.createElement)(r.Disabled,null,(0,t.createElement)(s(),{block:"motopress-hotel-booking/featured-image",attributes:a})))}})}();