export default {
    namespaced: true,

    state: {
        // conn: new WebSocket('ws://localhost:8080')
    },

    actions: {
        socket(ctx) {
            ctx.state.conn.onopen = function (e) {
                console.log('Connection established!');
                ctx.dispatch('send');
            };

            ctx.state.conn.onmessage = function (e) {
                let data = JSON.parse(e.data);

                console.log(data);
            };

            ctx.state.conn.onclose = function (e) {
                console.log('connection close');
            };

            ctx.state.conn.onerror = function (e) {
                console.log('connection error');
            };
        },

        send(ctx) {
            // let data = {
            //     id: 3,
            //     name: 'Техника-99',
            //     status: 1,
            //     date: '24.04.22 18:09:17',
            //     repairman: 'Отсутствует',
            //     cabinet: '455',
            //     description: 'wow',
            //     button: '',
            //     visibility: false
            // }

            ctx.state.conn.send('{"message": "new statement", "id": "3", "name": "Техника-99", "status": "1", "date": "24.04.22 18:09:17", "repairman": "Отсутствует", "cabinet":"399", "description":"wow"}');
            // console.log('Отправлено: ' + data);
        },


    },

    mutations: {

    },

    getters: {

    }
}
