import React, {useState} from 'react';
import Button from "../ui/Button";
import useModal from "../../hooks/useModal";
import {ADMIN_CREATE, ADMIN_DELETE, ADMIN_EDIT} from "../../constants/Modals";
import moment from "moment/moment";
import Table from "../tables/Table";
import TableHead from "../tables/TableHead";
import TableBody from "../tables/TableBody";
import TableHeader from "../tables/TableHeader";
import TableData from "../tables/TableData";
import useBind from "../../hooks/useBind";
import {deleteAdmin} from "../../actions/Admins";
import Icon from "../ui/Icon";
import AdminDeleteModal from "../modal/AdminDeleteModal";
import AdminEditModal from "../modal/AdminEditModal";
import AdminCreateModal from "../modal/AdminCreateModal";

const columns = ['Usuário', 'Steam ID', 'Flags', 'Nota', 'Ações'];

export default function AdminsTable({admins, loading = true}) {
    const [adminEdit, setAdminEdit] = useState(null);
    const [adminDelete, setAdminDelete] = useState(null);

    const [openAdminCreate, , isAdminCreateOpen] = useModal(ADMIN_CREATE);
    const [openAdminEdit, , isAdminEditOpen] = useModal(ADMIN_EDIT);
    const [openAdminDelete, , isAdminDeleteOpen] = useModal(ADMIN_DELETE);

    function handleEdit(admin) {
        setAdminEdit(admin);
        openAdminEdit();
    }

    function handleDelete(admin) {
        setAdminDelete(admin);
        openAdminDelete();
    }

    return <>
        <AdminCreateModal open={isAdminCreateOpen}/>
        <AdminEditModal open={isAdminEditOpen} admin={adminEdit}/>
        <AdminDeleteModal open={isAdminDeleteOpen} admin={adminDelete}/>

        <div className="flex justify-between items-center">
            <h1>Admins</h1>
            <div>
                <Button onClick={openAdminCreate} size="sm" color="blue">Add admin</Button>
            </div>
        </div>

        <Table>
            <TableHead columns={columns}>
                {
                    (head) => <TableHeader key={head}>{head}</TableHeader>
                }
            </TableHead>
            <TableBody loading={loading} dataKey="id" data={Object.values(admins || {})}>
                {
                    (data) => <>
                        <TableData>
                            {data.username}
                        </TableData>
                        <TableData>
                            <span className="font-mono">{data.steamid}</span>
                        </TableData>
                        <TableData>
                            <span className="font-mono">{data.flags}</span>
                        </TableData>
                        <TableData>
                            {data.note}
                        </TableData>
                        <TableData>
                            <div className="flex">
                                <Button onClick={handleEdit.bind(this, data)} shadow3D={true} size="sm" color="blue">
                                    <div className="flex w-full h-full justify-center items-center">
                                        <Icon className="inline-flex" icon="edit" classes="m-0 p-0 h-4 w-4 text-grey-lightest"/>
                                    </div>
                                </Button>
                                <Button onClick={handleDelete.bind(this, data)} shadow3D={true} size="sm" color="red">
                                    Deletar
                                </Button>
                            </div>
                        </TableData>
                    </>
                }
            </TableBody>
        </Table>
    </>
}