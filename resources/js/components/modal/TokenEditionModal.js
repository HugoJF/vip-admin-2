import React, {useEffect} from 'react';
import {Button, Form, FormGroup, Input, Label, Modal, ModalBody, ModalFooter, ModalHeader, Spinner} from "reactstrap";
import {DateTimePicker} from 'react-widgets'
import momentLocalizer from 'react-widgets-moment'
import moment from "moment";
import {patchToken} from "../../actions/Tokens";
import {toast} from 'react-toastify';
import {useField, useForm} from "react-final-form-hooks";
import {laravelDateFormat} from "../../constants/variables";
import useBind from "../../hooks/useBind";
import useModal from "../../hooks/useModal";
import {TOKEN_EDIT} from "../../constants/Modals";
import useNumberField from "../../hooks/useNumberField";
import useTextareaField from "../../hooks/useTextareaField";
import useDateTimePicker from "../../hooks/useDateTimePicker";

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
export default function TokenEditionModal({open, token}) {
    const patch = useBind(patchToken);
    const {form, handleSubmit, submitting} = useForm({
        onSubmit, // the function to call with your form values upon valid submit
    });

    const [,closeEditionModal] = useModal(TOKEN_EDIT);

    const [,duration] = useNumberField('duration', form);
    const [,note] = useTextareaField('note', form);
    const [,expires_at] = useDateTimePicker('expires_at', form);

    useEffect(() => {
        if (open) refreshState();
    }, [open]);

    function refreshState() {
        if (token) {
            let {duration, note, expires_at} = token;
            form.initialize({duration, note, expires_at});
        }
    }

    async function onSubmit(values) {
        let {duration, note, expires_at} = values;

        expires_at = moment(expires_at);
        expires_at = expires_at.isValid() ? expires_at.format(laravelDateFormat) : undefined;

        await patch(token.id, {duration, note, expires_at})
            .then(tokenUpdated)
            .catch(tokenUpdateFail);
    }

    function close() {
        closeEditionModal();
    }

    function tokenUpdated(data) {
        toast.success('Token atualizado com sucesso!');
        close();
    }

    function tokenUpdateFail(data) {
        toast.error(`Erro ao atualizar token: ${data.message}`);
        close();
    }

    if (!token)
        return null;

    return (
        <Modal isOpen={open} toggle={close} backdrop={true}>
            <Form>
                <ModalHeader>Updating token {token.id}</ModalHeader>
                <ModalBody>
                    <FormGroup>
                        <Label for="duration">Duração</Label>
                        {duration}
                    </FormGroup>
                    <FormGroup>
                        <Label for="expiresAt">Data de expiração</Label>
                        {expires_at}
                    </FormGroup>
                    <FormGroup>
                        <Label for="note">Note</Label>
                        {note}
                    </FormGroup>
                </ModalBody>
                <ModalFooter>
                    {submitting && <Spinner color="dark"/>}
                    <Button disabled={submitting} color="primary" onClick={handleSubmit}>Update</Button>{' '}
                    <Button disabled={submitting} color="secondary" onClick={close}>Cancel</Button>
                </ModalFooter>
            </Form>
        </Modal>
    );
}