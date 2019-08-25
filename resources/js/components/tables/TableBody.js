import React from 'react';
import {Spinner} from "reactstrap";

export default function TableBody({loading = false, data = [], dataKey = 'key', children}) {
    return (
        <tbody>
        {
            loading
                ?
                <tr>
                    <td colSpan={100} className="w-full text-center p-8" style={{width: '100%'}}>
                        <Spinner className="mx-2"/> Carregando...
                    </td>
                </tr>
                :
                (
                    data.length > 0
                        ?
                        data.map((i) => (
                            <tr key={i[dataKey]}>
                                {
                                    children(i)
                                }
                            </tr>
                        ))
                        :
                        <tr>
                            <td colSpan={100} className="p-8 text-center text-xl font-light" style={{width: '100%'}}>Tabela vazia</td>
                        </tr>
                )
        }
        </tbody>
    );
}