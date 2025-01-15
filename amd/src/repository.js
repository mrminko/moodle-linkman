import {call as fetchMany} from 'core/ajax';

const deleteLinkmanItem = (id) => {
    return fetchMany([{
        methodname: 'local_linkman_link_reducer',
        args: {
            action: 'DELETE_ITEM',
            payload: {
                id: id,
            },
        },
    }])[0];
}

export {
    deleteLinkmanItem
}