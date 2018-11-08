export default {
    name: "nested-sets",

    data() {
        return {
            allCount: null,
            countDifference: null,
            deleteNodeId: null,
            feedbackMessage: "",
            feedbackError: "",
            appendNodeId: null,
            timing: null
        }
    },

    mounted() {
        this.fetchData();
    },

    methods: {
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
                let url = '/node/create';
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
            axios.get('/tree/fetch').then((response) => {
                this.setData(response);
            }).catch((error) => {
                this.setFeedback(error.response.data.message, 'error');
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