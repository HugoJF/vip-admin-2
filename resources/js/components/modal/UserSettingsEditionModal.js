import React, {useEffect} from 'react';
import {Button, Form, FormGroup, FormText, Input, Label, Modal, ModalBody, ModalFooter, ModalHeader, Spinner} from "reactstrap";
import {toast} from 'react-toastify';
import {patchUser} from "../../actions/Users";
import {useForm, useField} from 'react-final-form-hooks'
import useBind from "../../hooks/useBind";
import useModal from "../../hooks/useModal";
import {USER_SETTINGS} from "../../constants/Modals";
import useAuth from "../../hooks/useAuth";
import useTextField from "../../hooks/useTextField";

const validate = values => {
    const errors = {};

    if (!values.name)
        errors.name = 'Required';

    if (!values.tradelink)
        errors.tradelink = 'Required';

    if (!values.email)
        errors.email = 'Required';

    return errors;
};

export default function UserSettingsEditionModal() {
    const _patchUser = useBind(patchUser);

    const [,closeUserSettings, open] = useModal(USER_SETTINGS);

    const {form, handleSubmit, submitting} = useForm({
        onSubmit, // the function to call with your form values upon valid submit
        validate // a record-level validation function to check all form values
    });

    const {user} = useAuth();

    const [,name] = useTextField('name', form);
    const [,tradelink] = useTextField('tradelink', form);
    const [,email] = useTextField('email', form);

    useEffect(() => {
        if(open) refreshState();
    }, [open]);

    function refreshState() {
        form.initialize(user);
    }

    async function onSubmit(values) {
        await _patchUser(values)
            .then(userUpdated)
            .catch(userUpdateFail);
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
                <ModalHeader>Atualizando configurações de usuário</ModalHeader>
                <ModalBody>
                    <FormGroup>
                        <Label for="name">Nome</Label>
                        {name}
                        <FormText color="muted">
                            Se você quiser que a gente utilize seu nome real, digite ele aqui. Apenas será usado na dashboard e para emails :) <strong>(opcional)</strong>
                        </FormText>
                    </FormGroup>
                    <FormGroup>
                        <Label for="tradelink"><span className="text-red font-bold">* </span>Tradelink</Label>
                        {tradelink}
                        <FormText color="muted">
                            Esse é o link que utilizamos para enviar os pedidos de troca. Você pode achar sua URL <a href="https://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">clicando aqui</a>. <strong>(obrigatório apenas na compra com itens de CS:GO)</strong>
                        </FormText>
                    </FormGroup>
                    <FormGroup>
                        <Label for="email">Email</Label>
                        {email}
                        <FormText color="muted">
                            Utilizaremos esse email para enviar notificações de todos acontecimentos dentro da sua conta no VIP-Admin. <strong>(recomendado mas opcional)</strong>
                        </FormText>
                    </FormGroup>
                </ModalBody>
                <ModalFooter>
                    {submitting && <Spinner color="dark"/>}
                    <Button disabled={submitting} color="primary" >Update</Button>{' '}
                    <Button disabled={submitting} color="secondary" onClick={close}>Cancel</Button>
                </ModalFooter>
            </Form>
        </Modal>
    );
}