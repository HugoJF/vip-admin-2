import React, {Component, Fragment, useCallback, useState} from 'react';
import Tag from "../ui/Tag";
import TableHead from "../tables/TableHead";
import TableBody from "../tables/TableBody";
import TableHeader from "../tables/TableHeader";
import Button from "../ui/Button";
import Table from "../tables/Table";
import TableData from "../tables/TableData";
import Icon from "../ui/Icon";
import moment from 'moment';
import TokenDeletionModal from "../modal/TokenDeletionModal";
import TokenEditionModal from "../modal/TokenEditionModal";
import useRoutes from "../../hooks/useRoutes";
import useReactRouter from 'use-react-router';
import useModal from "../../hooks/useModal";
import {TOKEN_CREATE, TOKEN_DELETE, TOKEN_EDIT} from "../../constants/Modals";
import TokenCreationModal from "../modal/TokenCreationModal";
import Admin from "../Auth/Admin";

const columns = ['Token', 'Usuário', 'Duração', 'Tempo restante', 'Note', 'Estado', 'Ações'];

function diffDate(date) {
    let end = moment(date);
    let now = moment();
    return end.diff(now, 'second');
}

function tokenState(data) {
    let diff = diffDate(data.expires_at);

    if (data.order_id) {
        return {
            text: 'Usado',
            color: 'blue',
        }
    }

    if (diff < 0) {
        return {
            text: 'Expirado',
            color: 'red',
        };
    } else {
        return {
            text: 'Válido',
            color: 'green',
        };
    }
}

export default function TokensTable({tokens, loading = true}) {
    const routes = useRoutes();

    const [deletionToken, setDeletionToken] = useState(null);
    const [editionToken, setEditionToken] = useState(null);

    const [openTokenDelete, , isTokenDeleteOpen] = useModal(TOKEN_DELETE);
    const [openTokenEdition, , isTokenEditionOpen] = useModal(TOKEN_EDIT);
    const [openTokenCreate, , isTokenCreateOpen] = useModal(TOKEN_CREATE);

    function onToggleDeleteModal(token) {
        setDeletionToken(token);
        openTokenDelete();
    }

    function onToggleEditModal(token) {
        setEditionToken(token);
        openTokenEdition();
    }

    function redirectToDetails(data) {
        routes.tokens.show.redirect({tokenId: data.id});
    }

    return (
        <>
            <TokenDeletionModal open={isTokenDeleteOpen} token={deletionToken}/>
            <TokenEditionModal open={isTokenEditionOpen} token={editionToken}/>
            <TokenCreationModal open={isTokenCreateOpen}/>
            <div className="flex justify-between items-center">
                <h1>Tokens</h1>
                <Admin>
                    <div>
                        <Button onClick={openTokenCreate} size="sm" color="blue">Create token</Button>
                    </div>
                </Admin>
            </div>

            <Table>
                <TableHead columns={columns}>
                    {
                        (head) => <TableHeader key={head}>{head}</TableHeader>
                    }
                </TableHead>
                <TableBody loading={loading} dataKey="id" data={Object.values(tokens || {})}>
                    {
                        (data) => (
                            <>
                                <TableData>
                                    <span className="font-mono">#{data.id}</span>
                                </TableData>
                                <TableData>
                                    {data.user?.username}
                                </TableData>
                                <TableData>
                                    {data.duration}<span className="text-grey-darkest font-light text-sm"> dias</span>
                                </TableData>
                                <TableData title={data.expires_at}>
                                        <span className="whitespace-no-wrap">
                                            {
                                                data.expires_at && (moment(data.expires_at).diff(moment()) > 0)
                                                    ?
                                                    moment(data.expires_at).fromNow(true)
                                                    :
                                                    'N/A'
                                            }
                                            </span>
                                </TableData>
                                <TableData>
                                    <p className="text-sm font-light">{data.note}</p>
                                </TableData>
                                <TableData>
                                    {
                                        ((info) => <Tag color={info.color}>{info.text}</Tag>)(tokenState(data))
                                    }
                                </TableData>
                                <TableData>
                                    <div className="flex">
                                        <Admin>
                                            <Button onClick={onToggleEditModal.bind(this, data)} shadow3D={true} size="sm" color="blue">
                                                <div className="flex w-full h-full justify-center items-center">
                                                    <Icon className="inline-flex" icon="edit" classes="m-0 p-0 h-4 w-4 text-grey-lightest"/>
                                                </div>
                                            </Button>
                                        </Admin>
                                        <Button onClick={redirectToDetails.bind(this, data)} shadow3D={true} size="sm" color="white">
                                            Detalhes
                                        </Button>
                                        <Admin>
                                            <Button onClick={onToggleDeleteModal.bind(this, data)} shadow3D={true} size="sm" color="red">
                                                Deletar
                                            </Button>
                                        </Admin>
                                    </div>
                                </TableData>
                            </>
                        )
                    }
                </TableBody>
            </Table>
        </>
    );
}