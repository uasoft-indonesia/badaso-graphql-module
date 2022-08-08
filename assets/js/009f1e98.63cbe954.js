"use strict";(self.webpackChunkdoc=self.webpackChunkdoc||[]).push([[436],{3905:function(e,t,n){n.d(t,{Zo:function(){return s},kt:function(){return m}});var r=n(7294);function a(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function o(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function i(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?o(Object(n),!0).forEach((function(t){a(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):o(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function l(e,t){if(null==e)return{};var n,r,a=function(e,t){if(null==e)return{};var n,r,a={},o=Object.keys(e);for(r=0;r<o.length;r++)n=o[r],t.indexOf(n)>=0||(a[n]=e[n]);return a}(e,t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);for(r=0;r<o.length;r++)n=o[r],t.indexOf(n)>=0||Object.prototype.propertyIsEnumerable.call(e,n)&&(a[n]=e[n])}return a}var p=r.createContext({}),u=function(e){var t=r.useContext(p),n=t;return e&&(n="function"==typeof e?e(t):i(i({},t),e)),n},s=function(e){var t=u(e.components);return r.createElement(p.Provider,{value:t},e.children)},c={inlineCode:"code",wrapper:function(e){var t=e.children;return r.createElement(r.Fragment,{},t)}},d=r.forwardRef((function(e,t){var n=e.components,a=e.mdxType,o=e.originalType,p=e.parentName,s=l(e,["components","mdxType","originalType","parentName"]),d=u(n),m=a,f=d["".concat(p,".").concat(m)]||d[m]||c[m]||o;return n?r.createElement(f,i(i({ref:t},s),{},{components:n})):r.createElement(f,i({ref:t},s))}));function m(e,t){var n=arguments,a=t&&t.mdxType;if("string"==typeof e||a){var o=n.length,i=new Array(o);i[0]=d;var l={};for(var p in t)hasOwnProperty.call(t,p)&&(l[p]=t[p]);l.originalType=e,l.mdxType="string"==typeof e?e:a,i[1]=l;for(var u=2;u<o;u++)i[u]=n[u];return r.createElement.apply(null,i)}return r.createElement.apply(null,n)}d.displayName="MDXCreateElement"},2783:function(e,t,n){n.r(t),n.d(t,{frontMatter:function(){return l},contentTitle:function(){return p},metadata:function(){return u},toc:function(){return s},default:function(){return d}});var r=n(7462),a=n(3366),o=(n(7294),n(3905)),i=["components"],l={sidebar_position:2},p="Configuration",u={unversionedId:"getting-started/configuration",id:"getting-started/configuration",title:"Configuration",description:"1. badaso-graphql.php",source:"@site/docs/getting-started/configuration.md",sourceDirName:"getting-started",slug:"/getting-started/configuration",permalink:"/getting-started/configuration",editUrl:"https://github.com/uasoft-indonesia/badaso-graphql-module/edit/main/website/docs/getting-started/configuration.md",tags:[],version:"current",sidebarPosition:2,frontMatter:{sidebar_position:2},sidebar:"tutorialSidebar",previous:{title:"Installation",permalink:"/getting-started/installation"},next:{title:"How Create New Type",permalink:"/customization/create-type"}},s=[],c={toc:s};function d(e){var t=e.components,n=(0,a.Z)(e,i);return(0,o.kt)("wrapper",(0,r.Z)({},c,n,{components:t,mdxType:"MDXLayout"}),(0,o.kt)("h1",{id:"configuration"},"Configuration"),(0,o.kt)("ol",null,(0,o.kt)("li",{parentName:"ol"},"badaso-graphql.php")),(0,o.kt)("p",null,"if you want to change default route and default middleware of qraphql-module you can change this file"),(0,o.kt)("pre",null,(0,o.kt)("code",{parentName:"pre"},"<?php\n\nreturn [\n    'graphql_prefix_route' => 'badaso/graphql', \n    'middleware' => [\\Uasoft\\Badaso\\Module\\Graphql\\Middleware\\BadasoGraphQLMiddleware::class],\n];\n")),(0,o.kt)("ul",null,(0,o.kt)("li",{parentName:"ul"},(0,o.kt)("inlineCode",{parentName:"li"},"graphql_prefix_route")," is default route ",(0,o.kt)("inlineCode",{parentName:"li"},"badaso/graphql")),(0,o.kt)("li",{parentName:"ul"},(0,o.kt)("inlineCode",{parentName:"li"},"middleware")," is default middleware use class ",(0,o.kt)("inlineCode",{parentName:"li"},"\\Uasoft\\Badaso\\Module\\Graphql\\Middleware\\BadasoGraphQLMiddleware::class"))),(0,o.kt)("ol",{start:2},(0,o.kt)("li",{parentName:"ol"},"badaso-graphql-customize.php")),(0,o.kt)("p",null,"if you want to make changes or additions to the data type, query, and mutation you can edit this file"),(0,o.kt)("pre",null,(0,o.kt)("code",{parentName:"pre"},"return [\n    'core' => [\n        'generate_graphql' => \\Uasoft\\Badaso\\Module\\Graphql\\Core\\GenerateGraphql::class,\n        'generate_query_graphql' => \\Uasoft\\Badaso\\Module\\Graphql\\Core\\GenerateQueryGraphql::class,\n        'generate_mutation_graphql' => \\Uasoft\\Badaso\\Module\\Graphql\\Core\\GenerateMutationGraphql::class,\n    ],\n\n    'type' => [\n        App\\CustomizeBadasoGraphQL\\Type\\ExampleType::class,\n        App\\CustomizeBadasoGraphQL\\Type\\ExampleInputType::class,\n        // register type ...\n    ],\n\n    'query' => [\n        App\\CustomizeBadasoGraphQL\\ExampleQueryField::class,\n        // register query ...\n    ],\n\n    'mutation' => [\n        App\\CustomizeBadasoGraphQL\\ExampleMutationField::class,\n        App\\CustomizeBadasoGraphQL\\ExampleValidateMutationField::class,\n        // register mutation ...\n    ],\n];\n")),(0,o.kt)("ul",null,(0,o.kt)("li",{parentName:"ul"},(0,o.kt)("inlineCode",{parentName:"li"},"core")," is default generate type, query, and mutation table crud generate"),(0,o.kt)("li",{parentName:"ul"},(0,o.kt)("inlineCode",{parentName:"li"},"type")," is the place to register your new graphqhl type"),(0,o.kt)("li",{parentName:"ul"},(0,o.kt)("inlineCode",{parentName:"li"},"query")," is the place to register your new graphql query"),(0,o.kt)("li",{parentName:"ul"},(0,o.kt)("inlineCode",{parentName:"li"},"mutation")," is the place to register your new graphql mutation")))}d.isMDXComponent=!0}}]);