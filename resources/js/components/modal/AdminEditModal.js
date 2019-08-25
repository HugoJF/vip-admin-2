import React, {useEffect} from 'react';
import {Button, Form, FormGroup, Label, Modal, ModalBody, ModalFooter, ModalHeader, Spinner} from "reactstrap";
import momentLocalizer from 'react-widgets-moment'
import {toast} from 'react-toastify';
import {useField, useForm} from "react-final-form-hooks";
import useBind from "../../hooks/useBind";
import useModal from "../../hooks/useModal";
import {ADMIN_EDIT} from "../../constants/Modals";
import useTextareaField from "../../hooks/useTextareaField";
import {patchAdmin} from "../../actions/Admins";
import useTextField from "../../hooks/useTextField";

momentLocalizer();

/**
 * @return {null}
 */
export default function AdminEditModal({open, admin}) {
    const _patchAdmin = useBind(patchAdmin);

    const {form, handleSubmit, submitting} = useForm({
        onSubmit, // the function to call with your form values upon valid submit
    });

    const [,close] = useModal(ADMIN_EDIT);

    const [,username] = useTextField('username', form);
    const [,steamid] = useTextField('steamid', form);
    const [,flags] = useTextField('flags', form);
    const [,note] = useTextareaField('note', form);

    useEffect(() => {
        if (open) refreshState();
    }, [open]);

    function refreshState() {
        if (admin) {
            let {username, steamid, flags, note} = admin;
            form.initialize({username, steamid, flags, note});
        }
    }

    async function onSubmit(values) {
        let {username, steamid, flags, note} = values;


        await _patchAdmin(admin.id, {username, steamid, flags, note})
            .then(adminUpdated)
            .catch(adminUpdateFail);
    }

    function adminUpdated(data) {
        toast.success('Admin atualizado com sucesso!');
        close();
    }

    function adminUpdateFail(data) {
        toast.error(`Erro ao atualizar admin: ${data.message}`);
        close();
    }

    if (!admin)
        return null;

    return (
        <Modal isOpen={open} toggle={close} backdrop={true}>
            <Form>
                <ModalHeader>Updating admin {admin.id}</ModalHeader>
                <ModalBody>
                    <FormGroup>
                        <Label for="username">Nome</Label>
                        {username}
                    </FormGroup>
                    <FormGroup>
                        <Label for="steamid">SteamID</Label>
                        {steamid}
                    </FormGroup>
                    <FormGroup>
                        <Label for="flags">Flags</Label>
                        {flags}
                    </FormGroup>
                    <FormGroup>
                        <Label for="note">Nota</Label>
                        {note}
                    </FormGroup>
                </ModalBody>
                <ModalFooter>
                    {submitting && <Spinner color="dark"/>}
                    <Button disabled={submitting} color="primary" onClick={handleSubmit}>Atualizar</Button>{' '}
                    <Button disabled={submitting} color="secondary" onClick={close}>Cancelar</Button>
                </ModalFooter>
            </Form>
        </Modal>
    );
}