"use strict";(self.webpackChunkdoc=self.webpackChunkdoc||[]).push([[757],{3905:function(e,n,t){t.d(n,{Zo:function(){return s},kt:function(){return y}});var r=t(7294);function a(e,n,t){return n in e?Object.defineProperty(e,n,{value:t,enumerable:!0,configurable:!0,writable:!0}):e[n]=t,e}function o(e,n){var t=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);n&&(r=r.filter((function(n){return Object.getOwnPropertyDescriptor(e,n).enumerable}))),t.push.apply(t,r)}return t}function i(e){for(var n=1;n<arguments.length;n++){var t=null!=arguments[n]?arguments[n]:{};n%2?o(Object(t),!0).forEach((function(n){a(e,n,t[n])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(t)):o(Object(t)).forEach((function(n){Object.defineProperty(e,n,Object.getOwnPropertyDescriptor(t,n))}))}return e}function p(e,n){if(null==e)return{};var t,r,a=function(e,n){if(null==e)return{};var t,r,a={},o=Object.keys(e);for(r=0;r<o.length;r++)t=o[r],n.indexOf(t)>=0||(a[t]=e[t]);return a}(e,n);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);for(r=0;r<o.length;r++)t=o[r],n.indexOf(t)>=0||Object.prototype.propertyIsEnumerable.call(e,t)&&(a[t]=e[t])}return a}var u=r.createContext({}),c=function(e){var n=r.useContext(u),t=n;return e&&(t="function"==typeof e?e(n):i(i({},n),e)),t},s=function(e){var n=c(e.components);return r.createElement(u.Provider,{value:n},e.children)},l={inlineCode:"code",wrapper:function(e){var n=e.children;return r.createElement(r.Fragment,{},n)}},m=r.forwardRef((function(e,n){var t=e.components,a=e.mdxType,o=e.originalType,u=e.parentName,s=p(e,["components","mdxType","originalType","parentName"]),m=c(t),y=a,f=m["".concat(u,".").concat(y)]||m[y]||l[y]||o;return t?r.createElement(f,i(i({ref:n},s),{},{components:t})):r.createElement(f,i({ref:n},s))}));function y(e,n){var t=arguments,a=n&&n.mdxType;if("string"==typeof e||a){var o=t.length,i=new Array(o);i[0]=m;var p={};for(var u in n)hasOwnProperty.call(n,u)&&(p[u]=n[u]);p.originalType=e,p.mdxType="string"==typeof e?e:a,i[1]=p;for(var c=2;c<o;c++)i[c]=t[c];return r.createElement.apply(null,i)}return r.createElement.apply(null,t)}m.displayName="MDXCreateElement"},5190:function(e,n,t){t.r(n),t.d(n,{frontMatter:function(){return p},contentTitle:function(){return u},metadata:function(){return c},toc:function(){return s},default:function(){return m}});var r=t(7462),a=t(3366),o=(t(7294),t(3905)),i=["components"],p={sidebar_position:2},u="How Create New Query",c={unversionedId:"customization/create-query",id:"customization/create-query",title:"How Create New Query",description:"1. create a new class file in app/CustomizeBadasoGraphQL/ExampleQueryField::class",source:"@site/docs/customization/create-query.md",sourceDirName:"customization",slug:"/customization/create-query",permalink:"/customization/create-query",editUrl:"https://github.com/uasoft-indonesia/badaso-graphql-module/edit/main/website/docs/customization/create-query.md",tags:[],version:"current",sidebarPosition:2,frontMatter:{sidebar_position:2},sidebar:"tutorialSidebar",previous:{title:"How Create New Type",permalink:"/customization/create-type"},next:{title:"How Create New Mutation",permalink:"/customization/create-mutation"}},s=[],l={toc:s};function m(e){var n=e.components,t=(0,a.Z)(e,i);return(0,o.kt)("wrapper",(0,r.Z)({},l,t,{components:n,mdxType:"MDXLayout"}),(0,o.kt)("h1",{id:"how-create-new-query"},"How Create New Query"),(0,o.kt)("ol",null,(0,o.kt)("li",{parentName:"ol"},"create a new class file in ",(0,o.kt)("inlineCode",{parentName:"li"},"app/CustomizeBadasoGraphQL/ExampleQueryField::class"))),(0,o.kt)("pre",null,(0,o.kt)("code",{parentName:"pre"},"<?php\n\nnamespace App\\CustomizeBadasoGraphQL;\n\nuse GraphQL\\Type\\Definition\\ResolveInfo;\nuse GraphQL\\Type\\Definition\\Type;\nuse Uasoft\\Badaso\\Module\\Graphql\\Core\\Abstracts\\BaseFieldAbstract;\n\nclass ExampleQueryField extends BaseFieldAbstract\n{\n    public function getName(): string\n    {\n        // name query\n        return 'exampleFieldQuery';\n    }\n\n    public function getType()\n    {\n        // get the previously registered example type\n        return $this->generate_graphql->getCustomizeDataType('example_type');\n\n        // or create new type\n        // return new \\GraphQL\\Type\\Definition\\ObjectType([\n        //     'name' => 'example_type',\n        //     'fields' => [\n        //         'company_name' => [\n        //             'type' => \\GraphQL\\Type\\Definition\\Type::string(),\n        //         ],\n        //         'library_name' => [\n        //             'type' => \\GraphQL\\Type\\Definition\\Type::string(),\n        //         ],\n        //         'module_name' => [\n        //             'type' => \\GraphQL\\Type\\Definition\\Type::string(),\n        //         ]\n        //     ]\n        // ]);\n    }\n\n    public function getArgs(): array\n    {\n        // parsing parameter for query\n        return [\n            'parameter1' => Type::nonNull(Type::string()),\n        ];\n    }\n\n    public function resolve($objectValue, $args, $context, ResolveInfo $info)\n    {\n        // show results\n        return [\n            'company_name' => 'Uasoft Indonesia',\n            'library_name' => 'Badaso',\n            'module_name' => 'Badaso GraphGL',\n        ];\n    }\n}\n")),(0,o.kt)("ol",{start:2},(0,o.kt)("li",{parentName:"ol"},"register class name in config ",(0,o.kt)("inlineCode",{parentName:"li"},"badaso-graphql-customize.php")," on the ",(0,o.kt)("inlineCode",{parentName:"li"},"type")," ")),(0,o.kt)("pre",null,(0,o.kt)("code",{parentName:"pre"},"...\n'query' => [\n    ...\n    App\\CustomizeBadasoGraphQL\\ExampleQueryField::class,\n    ...\n],\n...\n")))}m.isMDXComponent=!0}}]);