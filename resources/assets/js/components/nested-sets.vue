<template>
    <div class="tree-container">
        <h1>Nested sets</h1>

        <div class="initial-data">
            <h2>Tree data</h2>
            <ul>
                <li>Feedback:
                    <span class="dataEntry" v-bind:class="{ error : feedbackError }">
                        {{ feedbackMessage }}
                    </span>
                </li>
                <li>Timing : <span class="dataEntry">{{ timing }}</span></li>
                <li>Number of nodes in tree:
                    <span class="dataEntry">{{ allCount }}</span>
                    <span
                        v-if="countDifference !== null"
                        class="count-difference"
                    >
                        (
                        <span
                            class="plus-sign"
                            v-if="showPlus">+</span
                        >
                        {{ countDifference }}
                        )
                    </span>
                </li>
            </ul>
        </div>

        <div v-if="loading" id="overlay">
            <div>
                <vue-simple-spinner size="large"></vue-simple-spinner>
                <h4 class="load-inter-message">Loading ...</h4>
            </div>
        </div>

        <div>
            <!-- Random node -->
            <div class="tree-section check-tree">
                <div>
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        @click="checkTree"
                    >
                        Check tree
                    </button>
                </div>
            </div>

            <!-- Random node -->
            <div class="tree-section random-node">
                <div>
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        @click="randomNode"
                    >
                        Get random node info
                    </button>
                </div>
            </div>

            <!-- Random leaf -->
            <div class="tree-section random-leaf">
                <div>
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        @click="randomLeaf"
                    >
                        Get random leaf info
                    </button>
                </div>
            </div>

            <!-- Add node -->
            <div class="tree-section add-node">
                <div>
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        @click="appendNode"
                    >
                        Append node
                    </button>
                    <input
                        id="add-node"
                        class="form-control"
                        type="text"
                        placeholder="Node id"
                        v-model="appendNodeId"
                    />
                </div>
            </div>

            <!-- Delete non-root node -->
            <div class="tree-section delete-node">
                <div>
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        @click="deleteNode"
                    >
                        Delete node
                    </button>
                    <input
                        id="delete-node"
                        class="form-control"
                        type="text"
                        placeholder="Node id"
                        v-model="deleteNodeId"
                    />
                </div>
            </div>

            <!-- copy non-root node -->
            <div class="tree-section copy-node">
                <div>
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        @click="copyNode"
                    >
                        Copy node
                    </button>
                    <input
                        id="copy-node-self-id"
                        class="form-control"
                        type="text"
                        placeholder="Copy id"
                        v-model="copyNodeId"
                    />
                    <input
                        id="copy-node-parent-id"
                        class="form-control"
                        type="text"
                        placeholder="Parent id"
                        v-model="copyNodeParentId"
                    />
                </div>
            </div>
        </div>

        <div>
            <p>Random node info:</p>
            <div v-if="randomNodeInfo !== null">
                <span class="dataEntry">id: </span><span>{{ randomNodeInfo.id }}</span><br/>
                <span class="dataEntry">title: </span><span>{{ randomNodeInfo.title }}</span><br/>
                <span class="dataEntry">parent_id: </span><span>{{ randomNodeInfo.parent_id }}</span><br/>
                <span class="dataEntry">updated_at: </span><span>{{ randomNodeInfo.updated_at }}</span><br/>
                <span class="dataEntry">_lft: </span><span>{{ randomNodeInfo._lft }}</span><br/>
                <span class="dataEntry">_rgt: </span><span>{{ randomNodeInfo._rgt }}</span><br/>
                <span class="dataEntry">path: </span><span>{{ randomNodeInfo.path }}</span>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
    #overlay {
        position: fixed; /* Sit on top of the page content */
        display: block; /* Hidden by default */
        width: 100%; /* Full width (cover the whole page) */
        height: 100%; /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.5); /* Black background with opacity */
        z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
        cursor: pointer; /* Add a pointer on hover */

        h4 {
            text-align: center;
            color: white;
        }

        div {
            margin-top: 200px;
        }
    }

    .dataEntry {
        font-weight: bold;
    }

    .tree-container {
        padding: 20px;
    }

    .copy-node div input {
        margin-right: 10px;
    }

    .copy-node div input:last-child {
        margin-right: 0;
    }

    .tree-section {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    .tree-section div:first-child {
        display: flex;
        flex-direction: row;
    }

    .tree-section div:first-child button {
        margin-right: 20px;
    }

    .error {
        border-bottom: 3px solid indianred;
    }
</style>

<script src="./nested-sets.js"></script>