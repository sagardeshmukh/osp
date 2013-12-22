<?php
class CustomGuestbookForm extends GuestbookForm{
    public function configure() {
        parent::configure();
        unset($this['confirmed']);
    }
}