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
        /**
         * Performs the checkTree and countErrors on the table in the backend
         * @returns {void}
         */
        checkTree() {
            this.loading = true;

            axios.post('/tree/check', {}).then((response) => {
                this.setData(response);
            }).catch((error) => {
                this.setFeedback(error.response.data.message, 'error');
            }).finally(() => {
                this.loading = false;
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

        /**
         * Fetches a random node from the tree which root is id 1 in the table
         * @returns {void}
         */
        randomNode() {
            axios.post('/node/random/node', {}).then((response) => {
                this.setData(response);
                this.randomNodeInfo = response.data.node;
            }).catch((error) => {
                this.setFeedback(error.response.data.message, 'error');
                this.randomNodeInfo = null;
            }).finally(() => {
                this.randomNodeId = null;
            });
        },

        /**
         * Fetches a random leaf from the tree which root is id 1 in the table
         * @returns {void}
         */
        randomLeaf() {
            axios.post('/node/random/leaf', {}).then((response) => {
                this.setData(response);
                this.randomNodeInfo = response.data.node;
            }).catch((error) => {
                this.setFeedback(error.response.data.message, 'error');
                this.randomNodeInfo = null;
            }).finally(() => {
                this.randomLeafId = null;
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