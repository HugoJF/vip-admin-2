import React from 'react';

export default function TableHead({columns = [], children}) {
    return (
        <thead className="bg-grey-lighter border-t border-b border-grey-light">
        <tr>
            {
                columns.map((i) => (
                    children(i)
                ))
            }
        </tr>
        </thead>
    );
}