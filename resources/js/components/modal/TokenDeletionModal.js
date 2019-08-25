import React, {useState} from 'react';
import {Button, Modal, ModalBody, ModalFooter, ModalHeader, Spinner} from "reactstrap";
import {deleteToken} from "../../actions/Tokens";
import {toast} from "react-toastify";
import useModal from "../../hooks/useModal";
import useBind from "../../hooks/useBind";
import {TOKEN_DELETE} from "../../constants/Modals";

/**
 * @return {null}
 */

export default function TokenDeletionModal({open, token}) {
    const _deleteToken = useBind(deleteToken);
    const [loading, setLoading] = useState(false);
    const [,closeTokenDeletion] = useModal(TOKEN_DELETE);

    function handleDeleteToken() {
        setLoading(true);
        _deleteToken(token.id)
            .then(tokenDeleted)
            .catch(tokenDeletionFail);
    }

    function postDeleteToken() {
        setLoading(false);
        close();
    }

    function tokenDeleted(data) {
        toast.success(`Token removido com sucesso!`);
        postDeleteToken();
    }

    function tokenDeletionFail(data) {
        toast.error(`Erro ao remover token: ${data?.message}`);
        postDeleteToken();
    }

    function close() {
        closeTokenDeletion();
    }

    if (!token)
        return null;

    return (
        <Modal isOpen={open} toggle={close} backdrop={true}>
            <ModalHeader>Deletando token {token.id}</ModalHeader>
            <ModalBody>
                Você deseja deletar o token {token.id}
            </ModalBody>
            <ModalFooter>
                {loading && <Spinner color="dark"/>}
                <Button disabled={loading} color="danger" onClick={handleDeleteToken}>Deletar</Button>{' '}
                <Button disabled={loading} color="secondary" onClick={close}>Cancelar</Button>
            </ModalFooter>
        </Modal>
    );
}