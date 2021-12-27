"use strict";(self.webpackChunkdoc=self.webpackChunkdoc||[]).push([[893],{3905:function(e,n,t){t.d(n,{Zo:function(){return s},kt:function(){return p}});var r=t(7294);function a(e,n,t){return n in e?Object.defineProperty(e,n,{value:t,enumerable:!0,configurable:!0,writable:!0}):e[n]=t,e}function o(e,n){var t=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);n&&(r=r.filter((function(n){return Object.getOwnPropertyDescriptor(e,n).enumerable}))),t.push.apply(t,r)}return t}function i(e){for(var n=1;n<arguments.length;n++){var t=null!=arguments[n]?arguments[n]:{};n%2?o(Object(t),!0).forEach((function(n){a(e,n,t[n])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(t)):o(Object(t)).forEach((function(n){Object.defineProperty(e,n,Object.getOwnPropertyDescriptor(t,n))}))}return e}function c(e,n){if(null==e)return{};var t,r,a=function(e,n){if(null==e)return{};var t,r,a={},o=Object.keys(e);for(r=0;r<o.length;r++)t=o[r],n.indexOf(t)>=0||(a[t]=e[t]);return a}(e,n);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);for(r=0;r<o.length;r++)t=o[r],n.indexOf(t)>=0||Object.prototype.propertyIsEnumerable.call(e,t)&&(a[t]=e[t])}return a}var u=r.createContext({}),l=function(e){var n=r.useContext(u),t=n;return e&&(t="function"==typeof e?e(n):i(i({},n),e)),t},s=function(e){var n=l(e.components);return r.createElement(u.Provider,{value:n},e.children)},d={inlineCode:"code",wrapper:function(e){var n=e.children;return r.createElement(r.Fragment,{},n)}},m=r.forwardRef((function(e,n){var t=e.components,a=e.mdxType,o=e.originalType,u=e.parentName,s=c(e,["components","mdxType","originalType","parentName"]),m=l(t),p=a,f=m["".concat(u,".").concat(p)]||m[p]||d[p]||o;return t?r.createElement(f,i(i({ref:n},s),{},{components:t})):r.createElement(f,i({ref:n},s))}));function p(e,n){var t=arguments,a=n&&n.mdxType;if("string"==typeof e||a){var o=t.length,i=new Array(o);i[0]=m;var c={};for(var u in n)hasOwnProperty.call(n,u)&&(c[u]=n[u]);c.originalType=e,c.mdxType="string"==typeof e?e:a,i[1]=c;for(var l=2;l<o;l++)i[l]=t[l];return r.createElement.apply(null,i)}return r.createElement.apply(null,t)}m.displayName="MDXCreateElement"},8268:function(e,n,t){t.r(n),t.d(n,{frontMatter:function(){return c},contentTitle:function(){return u},metadata:function(){return l},toc:function(){return s},default:function(){return m}});var r=t(7462),a=t(3366),o=(t(7294),t(3905)),i=["components"],c={sidebar_position:5},u="How Create Middleware",l={unversionedId:"customization/middleware",id:"customization/middleware",title:"How Create Middleware",description:"You can add middleware for graphql requests",source:"@site/docs/customization/middleware.md",sourceDirName:"customization",slug:"/customization/middleware",permalink:"/customization/middleware",editUrl:"https://github.com/uasoft-indonesia/badaso-graphql-module/edit/main/website/docs/customization/middleware.md",tags:[],version:"current",sidebarPosition:5,frontMatter:{sidebar_position:5},sidebar:"tutorialSidebar",previous:{title:"How Create Validation For Query and Mutation Type",permalink:"/customization/input-validation"}},s=[],d={toc:s};function m(e){var n=e.components,t=(0,a.Z)(e,i);return(0,o.kt)("wrapper",(0,r.Z)({},d,t,{components:n,mdxType:"MDXLayout"}),(0,o.kt)("h1",{id:"how-create-middleware"},"How Create Middleware"),(0,o.kt)("p",null,"You can add middleware for graphql requests"),(0,o.kt)("pre",null,(0,o.kt)("code",{parentName:"pre"},"class ExampleValidateMutationField extends BaseFieldAbstract\n{   \n    ...\n    public function middlewareResolveHandle($objectValue, $args, $context, ResolveInfo $info)\n    {\n        ['whatCompanyName' => $what_company_name] = $args;\n\n        if ($what_company_name == 'uasoft indonesia') {\n            $random = rand(1, 9999);\n\n            return [\n                'company_name' => 'success[flag=\"'.Hash::make($random).'\"]',\n                'library_name' => 'success[flag=\"'.Hash::make($random).'\"]',\n                'module_name' => 'success[flag=\"'.Hash::make($random).'\"]',\n            ];\n        }\n\n        return $this->next($objectValue, $args, $context, $info);\n    }\n    ...\n}\n")))}m.isMDXComponent=!0}}]);