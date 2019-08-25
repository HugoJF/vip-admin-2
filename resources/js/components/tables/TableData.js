import React from 'react';

export default function TableData({children, ...rest}) {
    return (
        <td {...rest} className="py-2 px-3">
            {children}
        </td>
    )
}