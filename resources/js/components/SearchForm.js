import React, {useState} from 'react';
import {search} from "../actions/Search";
import useBind from "../hooks/useBind";

export default function SearchForm() {
    const _search = useBind(search);
    const [oldTerm, setOldTerm] = useState('');
    const [term, setTerm] = useState('');

    function onInputChange(e) {
        setTerm(e.target.value);
    }

    function onKeyDown(e) {
        if (e.key === 'Enter')
            _search(e.target.value);
    }

    function onFocus(e) {
        setTerm(oldTerm);
    }

    function onBlur(e) {
        setOldTerm(term);
        setTerm('');
    }

    return (
        <>
            <input
                value={term}
                onChange={onInputChange}
                onBlur={onBlur}
                onFocus={onFocus}
                onKeyDown={onKeyDown}
                className="trans flex-grow text-grey-lighter py-4 md:py-2 px-5 bg-transparent outline-none focus:border-b focus:border-grey focus:shadow-inner focus:bg-grey-lightest focus:text-grey-darker" type="text" placeholder="Search" aria-label="Search"
            />
        </>
    );
}