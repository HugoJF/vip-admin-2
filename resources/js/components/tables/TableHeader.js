import React from 'react';

export default function TableHeader({children}) {
    return (
        <th className="py-2 px-3">
            {children}
        </th>
    )
}