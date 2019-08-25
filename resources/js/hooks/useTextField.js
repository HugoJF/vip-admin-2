import React from "react";
import {useField} from "react-final-form-hooks";
import useInputField from "./useInputField";

export default function useTextField(name, form, props) {
    return useInputField('text', name, form, props);
}