import React, {useEffect} from 'react';
import {Button, Form, FormGroup, FormText, Label, Modal, ModalBody, ModalFooter, ModalHeader, Spinner} from "reactstrap";
import {toast} from 'react-toastify';
import {useForm, useField} from 'react-final-form-hooks'
import useModal from "../../hooks/useModal";
import {APP_SETTINGS} from "../../constants/Modals";
import useDateTimePickerField from "../../hooks/useDateTimePicker";
import useNumberField from "../../hooks/useNumberField";


export default function AppSettingsModal() {
    const [, closeUserSettings, open] = useModal(APP_SETTINGS);

    const {form, handleSubmit, submitting} = useForm({
        onSubmit, // the function to call with your form values upon valid submit
    });

    const [orderDateLimit, orderDateLimitComponent] = useDateTimePickerField('order_date_limit', form);
    const [tradeOfferExpiration, tradeOfferExpirationComponent] = useNumberField('trade_offer_expiration', form);

    useEffect(() => {
        if (open) refreshState();
    }, [open]);

    function refreshState() {
        form.initialize({});
    }

    async function onSubmit(values) {
        alert(JSON.stringify(values, 0, 2));
    }

    function userUpdated(data) {
        toast.success('Configurações atualizadas com sucesso!');
        close();
    }

    function userUpdateFail(data) {
        toast.error(`Erro ao atualizar configurações: ${data.message}`);
        close();
    }

    function close() {
        closeUserSettings();
    }

    return (
        <Modal size="lg" isOpen={open} toggle={close} backdrop={true}>
            <Form onSubmit={handleSubmit}>
                <ModalHeader>Atualizando configurações da aplicação</ModalHeader>
                <ModalBody>
                    <FormGroup>
                        <Label for={orderDateLimit.input.name}>Data limite para pedidos</Label>
                        {orderDateLimitComponent}
                        <FormText color="muted">
                            Qual a data limite para duração dos pedidos.
                        </FormText>
                    </FormGroup>
                    <FormGroup>
                        <Label for={tradeOfferExpiration.input.name}>Tempo para expiração de uma tradeoffer</Label>
                        {tradeOfferExpirationComponent}
                        <FormText color="muted">
                            Quantos minutos o sistema deve esperar antes de cancelar uma tradeoffer pendente.
                        </FormText>
                    </FormGroup>
                </ModalBody>
                <ModalFooter>
                    {submitting && <Spinner color="dark"/>}
                    <Button disabled={submitting} color="primary">Atualizar</Button>{' '}
                    <Button disabled={submitting} color="secondary" onClick={close}>Cancelar</Button>
                </ModalFooter>
            </Form>
        </Modal>
    );
}