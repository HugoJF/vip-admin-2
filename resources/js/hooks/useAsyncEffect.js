import React, {useEffect} from 'react';

export default function useAsyncEffect(func, inputs) {
    useEffect(() => {
        func()
    }, inputs)
}