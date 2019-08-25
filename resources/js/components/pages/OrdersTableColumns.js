import React from "react";
import TableData from "../tables/TableData";
import moment from "moment/moment";
import Tag from "../ui/Tag";
import Button from "../ui/Button";
import Icon from "../ui/Icon";
import Admin from "../Auth/Admin";


function getState(data) {
    if (data.canceled)
        return {text: 'Cancelado', color: 'red'};

    if (moment(data.ends_at).diff(moment(), 'minutes') <= 0)
        return {text: 'Expirado', color: 'yellow'};

    if (data.uploaded)
        return {text: 'Ativo', color: 'green'};

    if (data.starts_at)
        return {text: 'Sincronizando', color: 'yellow'};

    if (data.paid)
        return {text: 'Pago', color: 'blue', pulse: true};

    return {text: 'Pendente', color: 'yellow'}
}


export default function columns(functions) {
    return {
        id: {
            header: 'ID',
            render: (data) => (
                <TableData>
                    <span className="font-mono">#{data.id}</span>
                </TableData>
            ),
        },
        username: {
            header: 'Usuário',
            render: (data) => (
                <TableData>
                    {data.user.username}
                </TableData>
            )
        },
        duration: {
            header: 'Duração',
            render: (data) => (
                <TableData>
                    {data.duration}<span className="text-grey-darkest font-light text-sm"> dias</span>
                </TableData>
            )
        },
        created_at: {
            header: 'Criado em',
            render: (data) => (
                <TableData title={data.created_at}>
                    {
                        data.created_at
                            ?
                            moment(data.created_at).fromNow()
                            :
                            'N/A'
                    }
                </TableData>
            )
        },
        state: {
            header: 'Estado',
            render: (data) => (
                <TableData>
                    {
                        ((s) => (
                            <Tag pulse={s.pulse} color={s.color}>{s.text}</Tag>
                        ))(getState(data))
                    }
                </TableData>
            )
        },
        actions: {
            header: 'Ações',
            render: (data) => (
                <TableData>
                    <div className="flex">
                        <Admin>
                            <Button border={['t', 'l']} shadow3D={true} size="sm" color="white">
                                <div className="flex w-full h-full justify-center items-center">
                                    <Icon className="inline-flex" icon="refresh-cw" classes="m-0 p-0 h-4 w-4 text-grey-darker"/>
                                </div>
                            </Button>
                        </Admin>
                        {
                            (data.paid && !data.starts_at) ?
                                <Button onClick={functions.handleActivatesOrder.bind(this, data)} pulse shadow3D={true} size="sm" color="green">
                                    Ativar
                                </Button>
                                :
                                undefined
                        }
                        <Admin>
                            <Button onClick={functions.onToggleEditModal.bind(this, data)} shadow3D={true} size="sm" color="blue">
                                Editar
                            </Button>
                        </Admin>
                        <Button border={['l', 't', 'r']} onClick={functions.redirectToDetails.bind(this, data)} shadow3D={true} size="sm" color="white">
                            Detalhes
                        </Button>
                    </div>
                </TableData>
            )
        }
    }
};
