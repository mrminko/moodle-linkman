import $ from 'jquery';
import ModalForm from 'core_form/modalform';

const Selectors = {
    addBtn: '.linkman-add',
    linkmanTable: 'linkman-table',
};

function initAddForm(e) {
    e.preventDefault();
    const element = e.target;
    const modalForm = getForm(element);
    modalForm.addEventListener(modalForm.events.FORM_SUBMITTED, () => {
        setTimeout(function() {
            location.reload();
        }, 300);
    } );
    // Show the form.
    modalForm.show();
}

function getForm(element) {
    const modalForm = new ModalForm({
        formClass: "local_linkman\\form\\link_add_form",
        // Add as many arguments as you need, they will be passed to the form:
        args: {id: element.getAttribute('data-id')},
        // Pass any configuration settings to the modal dialogue, for example, the title:
        modalConfig: {title: "Add external link"},
        // DOM element that should get the focus after the modal dialogue is closed:
        returnFocus: element,
    });
    return modalForm;
}

function init() {
    $(Selectors.addBtn).on('click',e => {
        initAddForm(e)
    })
}

export default {
    init
}