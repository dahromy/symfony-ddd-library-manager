import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['modal']

    open(event) {
        event.preventDefault();
        this.modalTarget.classList.remove('hidden');
    }

    close() {
        this.modalTarget.classList.add('hidden');
    }

    submitEnd(event) {
        if (event.detail.success) {
            this.close();
        }
    }
}
