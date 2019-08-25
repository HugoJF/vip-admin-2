import React from 'react';
import Steps from "../ui/Steps";
import Step from "../ui/Step";
import moment from "moment";
import Stand from "../ui/Stand";
import StandRow from "../ui/StandRow";
import StandLabel from "../ui/StandLabel";
import StandValue from "../ui/StandValue";

export default function Order({order}) {
    return (
        <>
            <h1>Pedido #{order?.id}</h1>

            <Steps className="my-10">
                <Step step={1} completed title="Gerar pedido"/>
                <Step step={2} completed={order?.paid} title="Pagar pedido"/>
                <Step step={3} completed={order?.starts_at !== undefined} title="Ativar"/>
                <Step step={4} title="Esperar sincronização"/>
            </Steps>

            <h2 className="mt-16 my-8">Detalhes</h2>
            <Stand>
                <StandRow>
                    <StandLabel>Usuário:</StandLabel>
                    <StandValue color="green">{order?.user?.username}</StandValue>
                </StandRow>
                <StandRow>
                    <StandLabel>Duração:</StandLabel>
                    <StandValue color="green">{order?.duration} dias</StandValue>
                </StandRow>
                <StandRow>
                    <StandLabel>Inicia em:</StandLabel>
                    <StandValue color="green">{
                        order?.starts_at
                            ?
                            moment(order?.starts_at).toString()
                            :
                            'N/A'
                    }</StandValue>
                </StandRow>
                <StandRow>
                    <StandLabel>Finaliza em:</StandLabel>
                    <StandValue color="green">{
                        order?.starts_at
                            ?
                            moment(order?.ends_at).toString()
                            :
                            'N/A'
                    }</StandValue>
                </StandRow>
                <StandRow>
                    <StandLabel>Estado:</StandLabel>
                    <StandValue color={order?.paid ? 'green' : 'red'}>{order?.paid ? 'Pago' : 'Pendente'}</StandValue>
                </StandRow>
            </Stand>

        </>
    );
}
