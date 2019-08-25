import React, {Component, Fragment} from 'react';
import Tag from "./ui/Tag";

// TODO: remove file?
class TableExample extends Component {
    render() {
        return (
            <>
                <div className="p-0 my-4 md:px-12 w-full overflow-x-auto">
                    <table className="w-full text-grey-darkest">
                        <thead className="bg-grey-lighter border-t border-b border-grey-light">
                        <tr>
                            <th className="py-2 px-3">ID do pedido</th>
                            <th className="py-2 px-3">Usuário</th>
                            <th className="py-2 px-3">Duração</th>
                            <th className="py-2 px-3">Criado em</th>
                            <th className="py-2 px-3">
                                <span>Estado</span>
                                <a href="#"><span className="text-grey-darker" data-feather="help-circle"/></a>
                            </th>
                            <th className="py-2 px-3">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td className="py-2 px-3 font-mono font-medium">#3c377c9e</td>
                            <td className="py-2 px-3">
                                <a href="#" className="text-blue font-semibold">Itachi</a>
                                <a className="group" href="#">
                                    <span className="ml-2 h-4 w-4 text-grey-darkest hover:-translate-px hover:text-black" data-feather="zoom-in"/>
                                </a>
                            </td>
                            <td className="py-2 px-3">30 dias</td>
                            <td className="py-2 px-3">
                                29 <span className="text-grey-darkest font-light text-sm">minutos atrás</span>
                            </td>
                            <td className="py-2 px-3">
                                <Tag
                                    color="red"
                                    text="Cancelado"
                                />
                            </td>
                            <td className="py-2 px-3">
                                <div className="flex">
                                    <a className="px-2 py-1 bg-grey-lightest border-t border-l border-grey shadow-3d-white-sm font-medium text-sm">
                                        <div className="flex w-full h-full justify-center items-center"><span className="m-0 p-0 h-4 w-4 text-grey-darker" data-feather="refresh-cw"/></div>
                                    </a>
                                    <a className="inline-block px-3 py-1 bg-blue shadow-3d-blue-sm font-medium text-sm text-blue-lightest text">Detalhes</a>
                                    <a className="inline-block px-3 py-1 bg-red shadow-3d-red-sm font-medium text-sm text-red-lightest text">Deletar</a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </>
        );
    }
}

export default TableExample;