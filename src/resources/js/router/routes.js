import Pages from "./../pages/index";

let prefix = process.env.MIX_ADMIN_PANEL_ROUTE_PREFIX
  ? "/" + process.env.MIX_ADMIN_PANEL_ROUTE_PREFIX
  : "/badaso-admin";

export default [
  {
    path: prefix + "/graphql",
    name: "GraphqlPlaygroundBrowse",
    component: Pages,
    meta: {
      title: "GraphQL Playground",
      useComponent: "AdminContainer",
    },
  },
];
