import React, {useEffect} from 'react';
import {Button, CustomInput, Form, FormGroup, Label, Modal, ModalBody, ModalFooter, ModalHeader, Spinner} from "reactstrap";
import moment from "moment";
import {toast} from 'react-toastify';
import {patchOrder} from "../../actions/Orders";
import {useForm, useField} from 'react-final-form-hooks'
import {laravelDateFormat} from "../../constants/variables";
import useBind from "../../hooks/useBind";
import useModal from "../../hooks/useModal";
import {ORDER_EDIT} from "../../constants/Modals";
import useDateTimePicker from "../../hooks/useDateTimePicker";


export default function TokenEditionModal({open, order}) {
    const _patchOrder = useBind(patchOrder);
    const [,closeOrderEdition] = useModal(ORDER_EDIT);
    const {form, handleSubmit, submitting} = useForm({
        onSubmit, // the function to call with your form values upon valid submit
    });

    const [, startsAtComponent] = useDateTimePicker('starts_at', form);
    const [, endsAtComponent] = useDateTimePicker('ends_at', form);
    const paid = useField('paid', form);
    const canceled = useField('canceled', form);

    useEffect(() => {
        if (open) refreshState();
    }, [open]);

    function refreshState() {
        console.log('refreshing', order);
        if (order) {
            let {starts_at, ends_at, paid, canceled} = order;
            form.initialize({starts_at, ends_at, paid, canceled});
        }
    }

    async function onSubmit(values) {
        let {starts_at, ends_at, paid, canceled} = values;

        starts_at = moment(starts_at);
        starts_at = starts_at.isValid() ? starts_at.format(laravelDateFormat) : undefined;
        ends_at= moment(ends_at);
        ends_at = ends_at.isValid() ? ends_at.format(laravelDateFormat) : undefined;

        await _patchOrder(order.id, {starts_at, ends_at, paid, canceled})
            .then(orderUpdated)
            .catch(orderUpdateFail);
    }

    function close() {
        closeOrderEdition();
    }

    function orderUpdated(data) {
        toast.success('Pedido atualizado com sucesso!');
        close();
    }

    function orderUpdateFail(data) {
        toast.error('Erro ao atualizar token.');
        close();
    }

    return (
        <Modal isOpen={open} toggle={close} backdrop={true}>
            <Form onSubmit={handleSubmit}>
                <ModalHeader>Updating order {order?.id}</ModalHeader>
                <ModalBody>
                    <FormGroup>
                        <Label for="starts_at">Data de início</Label>
                        {startsAtComponent}
                    </FormGroup>
                    <FormGroup>
                        <Label for="ends_at">Data de fim</Label>
                        {endsAtComponent}
                    </FormGroup>
                    <FormGroup>
                        <Label for="paid">Status</Label>
                        <CustomInput id={paid.input.name} checked={paid.input.value} {...paid.input} type="checkbox" label="Pago"/>
                        <CustomInput id={canceled.input.name} checked={canceled.input.value} {...canceled.input} type="checkbox" label="Cancelado"/>
                    </FormGroup>
                </ModalBody>
                <ModalFooter>
                    {submitting && <Spinner color="dark"/>}
                    <Button disabled={submitting} color="primary">Update</Button>{' '}
                    <Button disabled={submitting} color="secondary" onClick={close}>Cancel</Button>
                </ModalFooter>
            </Form>
        </Modal>
    );
}