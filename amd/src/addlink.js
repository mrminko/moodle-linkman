import $ from 'jquery';
import ModalForm from 'core_form/modalform';
import ModalDeleteCancel from 'core/modal_delete_cancel';
import ModalEvents from 'core/modal_events';
import {getString} from 'core/str';
import {deleteLinkmanItem} from './repository';
import Notification from "core/notification";

const Selectors = {
    addBtn: '.linkman-add',
    linkmanTable: 'linkman-table',
    editBtn: '[data-action="linkman-item-edit"]',
    deleteBtn: '[data-action="linkman-item-delete"]'
};

async function getDeleteForm(element) {
    const id = element.getAttribute('data-id');
    const modal = await ModalDeleteCancel.create({
        title: 'Delete external link',
        body: getString('confirmdelete', 'local_linkman'),
    });
    modal.getRoot().on(ModalEvents.delete, (e) => {
        const promise = deleteLinkmanItem(id);
        promise.then(result => {
            if(result.success) {
                setTimeout(function() {
                    location.reload();
                }, 200);
            } else {
                Notification.addNotification({
                    message: "Error when deleting external link.",
                    type: 'error'
                })
            }
        }).catch( error => {
            Notification.exception(new Error('Error when dealing with webservice.'));
        })
    })
    return modal;
}

function showForm(e, type) {
    e.preventDefault();
    const element = e.target;
    switch (type) {
        case 'ADD_FORM':
            const modalForm = getAddForm(element);
            modalForm.addEventListener(modalForm.events.FORM_SUBMITTED, event => {
                setTimeout(function() {
                    location.reload();
                }, 200);
            });
            // Show the form.
            modalForm.show();
            break;
        case 'EDIT_FORM':
            const editForm = getEditForm(element);
            editForm.addEventListener(editForm.events.FORM_SUBMITTED, event => {
                setTimeout(function() {
                    location.reload();
                }, 200);
            });
            // Show the form.
            editForm.show();
            break;
        case 'DELETE_FORM':
            const deleteFormPromise = getDeleteForm(element);
            // Show the form.
            deleteFormPromise.then((deleteForm) => deleteForm.show());
            break;
    }
}

function getAddForm(element) {
    return new ModalForm({
        formClass: "local_linkman\\form\\link_add_form",
        // Add as many arguments as you need, they will be passed to the form:
        args: {action: "ADD_ITEM"},
        // Pass any configuration settings to the modal dialogue, for example, the title:
        modalConfig: {title: "Add external link"},
        // DOM element that should get the focus after the modal dialogue is closed:
        returnFocus: element,
    });
}

function getEditForm(element) {
    const id = element.getAttribute('data-id');
    const name = element.getAttribute('data-name');
    const base_link = element.getAttribute('data-baselink');
    const note = element.getAttribute('data-note');
    return new ModalForm({
        formClass: "local_linkman\\form\\link_add_form",
        // Add as many arguments as you need, they will be passed to the form:
        args: {action: "EDIT_ITEM", data: {id, name, base_link, note}},
        // Pass any configuration settings to the modal dialogue, for example, the title:
        modalConfig: {title: "Edit external link"},
        // DOM element that should get the focus after the modal dialogue is closed:
        returnFocus: element,
    });
}

function init() {
    $(Selectors.addBtn).on('click',e => {
        showForm(e, 'ADD_FORM')
    });
    $(Selectors.editBtn).on('click',e => {
        showForm(e, 'EDIT_FORM')
    });
    $(Selectors.deleteBtn).on('click',e => {
        showForm(e, 'DELETE_FORM')
    })
}

export default {
    init
}