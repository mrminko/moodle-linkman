import {call as fetchMany} from 'core/ajax';

const getInitialData = () => {
    return fetchMany([{
        methodname: 'local_linkman_link_reducer',
        args: {
            action: 'init',
            payload: [],
        },
    }])[0];
}

export {
    getInitialData
}