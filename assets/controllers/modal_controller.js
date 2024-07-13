import { Controller } from '@hotwired/stimulus';
import { Modal } from 'bootstrap';

export default class extends Controller {
    static targets = ['modal']

    connect() {
        this.modal = new Modal(this.modalTarget);
    }

    open(event) {
        event.preventDefault();
        this.modal.show();
    }

    close() {
        this.modal.hide();
    }

    submitEnd(event) {
        if (event.detail.success) {
            this.modal.hide();
        }
    }
}
