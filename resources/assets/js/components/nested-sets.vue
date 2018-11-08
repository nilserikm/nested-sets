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

        <!-- Add node -->
        <div class="tree-section add-node">
            <div>
                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    @click="appendNode"
                >
                    Append node to
                </button>
                <input
                    id="add-node"
                    class="form-control"
                    type="text"
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
                    v-model="deleteNodeId"
                />
            </div>
        </div>
    </div>
</template>

<style lang="scss">
    .tree-container {
        padding: 20px;
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