<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action"> </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('browse_graphql')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("graphql_playground.title") }}</h3>
          </div>
          <iframe
            :src="graphqlPlaygroundUri"
            style="width: 100%; height: 700px; overflow: hidden; border: none;"
          />
        </vs-card>
      </vs-col>
    </vs-row>
    <vs-row v-else>
      <vs-col vs-lg="12">
        <vs-card>
          <vs-row>
            <vs-col vs-lg="12">
              <h3>{{ $t("graphql_playground.warning.notAllowedToBrowse") }}</h3>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>
<script>
export default {
  name: "GraphqlPlaygroundBrowse",
  components: {},
  data() {
    return {
      statusCode: null,
      message: null,
      isShow: true,
      urlIframe: null,
    };
  },
  async created() {
    await this.requestCheckPageIFrame();
  },
  computed: {
    graphqlPlaygroundUri() {
      let graphqlPlaygroundUri = process.env.MIX_GRAPHQL_PREFIX_URI
        ? process.env.MIX_GRAPHQL_PREFIX_URI
        : "/graphql-playground";
      let host = window.location.origin;
      let token = localStorage.getItem("token");
      let url = `${host}${graphqlPlaygroundUri}?token=${token}`;
      return url;
    },
  },
};
</script>
