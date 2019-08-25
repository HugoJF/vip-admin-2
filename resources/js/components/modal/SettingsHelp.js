import React, {useEffect} from 'react';
import {Button, Form, FormGroup, FormText, Label, Modal, ModalBody, ModalFooter, ModalHeader, Spinner} from "reactstrap";
import {toast} from 'react-toastify';
import {useForm, useField} from 'react-final-form-hooks'
import useModal from "../../hooks/useModal";
import {APP_SETTINGS, DASHBOARD_HELP, ORDERS_HELP, SETTINGS_HELP, TOKENS_HELP} from "../../constants/Modals";
import useAuth from "../../hooks/useAuth";
import useDateTimePickerField from "../../hooks/useDateTimePicker";
import useNumberField from "../../hooks/useNumberField";


export default function SettingsHelp() {
    const [, close, open] = useModal(SETTINGS_HELP);

    return (
        <Modal size="lg" isOpen={open} toggle={close} backdrop={true}>
                <ModalHeader>Sobre a Dashboard</ModalHeader>
                <ModalBody>
                    A dashboard é a página onde todas as informações básicas do sistemas estão disponíveis:
                    <ul>
                        <li>Preços</li>
                        <li>Regras</li>
                        <li>Mensagens dos administradores</li>
                        <li>Atualizações do sistema</li>
                    </ul>
                </ModalBody>
                <ModalFooter>
                    <Button color="secondary" onClick={close}>Fechar</Button>
                </ModalFooter>
        </Modal>
    );
}