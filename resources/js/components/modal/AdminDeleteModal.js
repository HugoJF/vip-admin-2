import React, {useState} from 'react';
import {Button, Modal, ModalBody, ModalFooter, ModalHeader, Spinner} from "reactstrap";
import {toast} from "react-toastify";
import useModal from "../../hooks/useModal";
import useBind from "../../hooks/useBind";
import {ADMIN_DELETE} from "../../constants/Modals";
import {deleteAdmin} from "../../actions/Admins";

/**
 * @return {null}
 */

export default function AdminDeleteModal({open, admin}) {
    const _deleteAdmin = useBind(deleteAdmin);

    const [loading, setLoading] = useState(false);

    const [,close] = useModal(ADMIN_DELETE);

    function handleAdminDelete() {
        setLoading(true);
        _deleteAdmin(admin.id)
            .then(adminDeleted)
            .catch(adminDeletionFail);
    }

    function postDeleteAdmin() {
        setLoading(false);
        close();
    }

    function adminDeleted(data) {
        toast.success(`Admin removido com sucesso!`);
        postDeleteAdmin();
    }

    function adminDeletionFail(data) {
        toast.error(`Erro ao remover admin: ${data?.message}`);
        postDeleteAdmin();
    }


    if (!admin)
        return null;

    return (
        <Modal isOpen={open} toggle={close} backdrop={true}>
            <ModalHeader>Deletando admin {admin.username} ({admin.steamid})</ModalHeader>
            <ModalBody>
                Você deseja deletar o admin {admin.steamid}
            </ModalBody>
            <ModalFooter>
                {loading && <Spinner color="dark"/>}
                <Button disabled={loading} color="danger" onClick={handleAdminDelete}>Deletar</Button>{' '}
                <Button disabled={loading} color="secondary" onClick={close}>Cancelar</Button>
            </ModalFooter>
        </Modal>
    );
}