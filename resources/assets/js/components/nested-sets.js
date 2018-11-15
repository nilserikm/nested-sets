export default {
    name: "nested-sets",

    data() {
        return {
            allCount: null,
            appendNodeId: null,
            copyNodeId: null,
            copyNodeParentId: null,
            countDifference: null,
            deleteNodeId: null,
            feedbackMessage: "",
            feedbackError: "",
            loading: false,
            randomLeafId: null,
            randomNodeId: null,
            randomNodeInfo: null,
            timing: null
        }
    },

    mounted() {
        this.fetchData();
    },

    methods: {
        checkTree() {
            axios.post('/tree/check', {}).then((response) => {
                this.setData(response);
            }).catch((error) => {
                this.setFeedback(error.response.data.message, 'error');
            });
        },

        copyNode() {
            if (isNaN(parseInt(this.copyNodeId)) || isNaN(parseInt(this.copyNodeParentId))) {
                this.copyNodeId = "";
                this.setFeedback("No node ID specified ...", 'error');
            } else {
                let url = '/node/copy';
                let data = {
                    'nodeId': this.copyNodeId,
                    'parentId': this.copyNodeParentId
                };
                axios.post(url, data).then((response) => {
                    this.setData(response);
                    this.copyNodeId = null;
                    this.copyNodeParentId = null;
                }).catch((error) => {
                    this.setFeedback(error.response.data.message, 'error');
                    this.copyNodeId = null;
                    this.copyNodeParentId = null;
                });
            }
        },

        randomNode() {
            let url = '/node/random/node';
            let data = {};

            axios.post(url, data).then((response) => {
                this.setData(response);
                this.randomNodeId = null;
                this.randomNodeInfo = response.data.node;
            }).catch((error) => {
                this.setFeedback(error.response.data.message, 'error');
                this.randomNodeId = null;
                this.randomNodeInfo = null;
            });
        },

        randomLeaf() {
            let url = '/node/random/leaf';
            let data = {};

            axios.post(url, data).then((response) => {
                this.setData(response);
                this.randomLeafId = null;
                this.randomNodeInfo = response.data.node;
            }).catch((error) => {
                this.setFeedback(error.response.data.message, 'error');
                this.randomLeafId = null;
                this.randomNodeInfo = null;
            });
        },

        deleteNode() {
            if (isNaN(parseInt(this.deleteNodeId))) {
                this.deleteNodeId = "";
                this.setFeedback("No node ID specified ...", 'error');
            } else {
                let url = '/node/delete';
                let data = { 'nodeId': this.deleteNodeId };
                axios.post(url, data).then((response) => {
                    this.setData(response);
                    this.deleteNodeId = null;
                }).catch((error) => {
                    this.setFeedback(error.response.data.message, 'error');
                    this.deleteNodeId = null;
                });
            }
        },

        appendNode() {
            if (isNaN(parseInt(this.appendNodeId))) {
                this.appendNodeId = "";
                this.setFeedback("No node ID specified ...", 'error');
            } else {
                let url = '/node/append';
                let data = { 'parentId': this.appendNodeId };
                axios.post(url, data).then((response) => {
                    this.setData(response);
                    this.appendNodeId = null;
                }).catch((error) => {
                    this.setFeedback(error.response.data.message, 'error');
                    this.appendNodeId = null;
                });
            }
        },

        fetchData() {
            this.loading = true;
            axios.get('/tree/fetch').then((response) => {
                this.setData(response);
            }).catch((error) => {
                this.setFeedback(error.response.data.message, 'error');
            }).finally(() => {
                this.loading = false;
            });
        },

        setData(response) {
            this.countDifference = response.data.allCount - this.allCount;
            this.allCount = response.data.allCount;
            this.timing = response.data.time;
            this.setFeedback(response.data.message);
        },

        /**
         * Sets the error message
         * @param message
         * @param type - string
         * @returns {void}
         */
        setFeedback(message, type="response") {
            if (type.localeCompare("error") === 0) {
                this.feedbackError = true;
            } else {
                this.feedbackError = false;
            }

            this.feedbackMessage = message;
        },

        /**
         * Returns true if the plus-sign before countDifference should be
         * displayed
         * @returns {boolean}
         */
        showPlus() {
            if (this.countDifference !== null) {
                if (Math.sign(this.countDifference) === 1) {
                    return true;
                }
            }

            return false;
        }
    }
}