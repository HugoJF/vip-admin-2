import React, {useEffect} from 'react';
import {Button, Form, FormGroup, Input, Label, Modal, ModalBody, ModalFooter, ModalHeader, Spinner} from "reactstrap";
import {DateTimePicker} from 'react-widgets'
import momentLocalizer from 'react-widgets-moment'
import moment from "moment";
import {postToken} from "../../actions/Tokens";
import {toast} from 'react-toastify';
import {useField, useForm} from "react-final-form-hooks";
import {laravelDateFormat} from "../../constants/variables";
import useBind from "../../hooks/useBind";
import useModal from "../../hooks/useModal";
import {TOKEN_CREATE} from "../../constants/Modals";
import useDateTimePicker from "../../hooks/useDateTimePicker";
import useTextField from "../../hooks/useTextField";
import useNumberField from "../../hooks/useNumberField";
import useTextareaField from "../../hooks/useTextareaField";

momentLocalizer();

let props = {
    max: new Date(2099, 11, 31),
    date: true,
    time: true,
    format: 'dddd, MMMM Do YYYY, h:mm:ss',
};

/**
 * @return {null}
 */
export default function TokenCreationModal({open}) {
    const _postToken = useBind(postToken);
    const {form, handleSubmit, submitting} = useForm({
        onSubmit, // the function to call with your form values upon valid submit
    });

    const [, closeCreateModal] = useModal(TOKEN_CREATE);

    const [,code] = useTextField('code', form);
    const [,duration] = useNumberField('duration', form);
    const [,note] = useTextareaField('note', form);
    const [,expiresAt] = useDateTimePicker('expires_at', form);

    useEffect(() => {
        if (open) refreshState();
    }, [open]);

    function refreshState() {
        form.reset();
    }

    async function onSubmit(values) {
        let {code, duration, note, expires_at} = values;

        expires_at = moment(expires_at);
        expires_at = expires_at.isValid() ? expires_at.format(laravelDateFormat) : undefined;

        await _postToken({id: code, duration, note, expires_at})
            .then(tokenUpdated)
            .catch(tokenUpdateFail);
    }

    function close() {
        closeCreateModal();
    }

    function tokenUpdated(data) {
        toast.success('Token gerado com sucesso!');
        close();
    }

    function tokenUpdateFail(data) {
        toast.error(`Erro ao gerado token: ${data.message}`);
        close();
    }

    return (
        <Modal isOpen={open} toggle={close} backdrop={true}>
            <Form>
                <ModalHeader>Creating token</ModalHeader>
                <ModalBody>
                    <FormGroup>
                        <Label for="code">Código</Label>
                        {code}
                    </FormGroup>
                    <FormGroup>
                        <Label for="duration">Duração</Label>
                        {duration}
                    </FormGroup>
                    <FormGroup>
                        <Label for="expiresAt">Data de expiração</Label>
                        {expiresAt}
                    </FormGroup>
                    <FormGroup>
                        <Label for="note">Note</Label>
                        {note}
                    </FormGroup>
                </ModalBody>
                <ModalFooter>
                    {submitting && <Spinner color="dark"/>}
                    <Button disabled={submitting} color="primary" onClick={handleSubmit}>Criar</Button>{' '}
                    <Button disabled={submitting} color="secondary" onClick={close}>Cancelar</Button>
                </ModalFooter>
            </Form>
        </Modal>
    );
}