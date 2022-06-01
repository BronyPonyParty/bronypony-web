export default {
    namespaced: true,

    state: {
        conn: new WebSocket('ws://localhost:8080')
    },

    actions: {
        socket(ctx) {
            ctx.state.conn.onopen = function (e) {
                console.log('Connection established!');
            };

            ctx.state.conn.onmessage = function (e) {
                let data = JSON.parse(e.data);
                console.log(data);

                if (data.message === 'accept statement') {
                    let statements = ctx.rootGetters['statements/getItems'];
                    statements.forEach(function (statement, index) {
                       if (statement.id === data.statementId) {
                           ctx.commit('statements/changeItemProperty', [index, 'repairMan', data.name], { root:true });
                           ctx.commit('statements/changeItemProperty', [index, 'repairManId', data.repairManId], { root:true });
                           ctx.commit('statements/changeItemProperty', [index, 'status', 2], { root:true });
                       }
                    });
                }

                else if (data.message === 'complete statement') {
                    let statements = ctx.rootGetters['statements/getItems'];
                    statements.forEach(function (statement, index) {
                        if (statement.id === data.statementId) {
                            ctx.commit('statements/removeItem', index, { root:true });
                        }
                    });
                }
            }
            ;

            ctx.state.conn.onclose = function (e) {
                console.log('connection close');
            };

            ctx.state.conn.onerror = function (e) {
                console.log('connection error');
            };
        },

        send(ctx, data) {
            ctx.state.conn.send(JSON.stringify(data));
            console.log('success send');
        },

        leaveRoom(ctx) {
            const data = {
                message: 'leave room'
            };

            ctx.state.conn.send(JSON.stringify(data));
        }
    },

    mutations: {

    },

    getters: {
        getConnect(state) {
            return state.conn;
        }
    }
}
