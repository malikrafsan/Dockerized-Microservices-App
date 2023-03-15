import { useState } from 'react'
import { Button, Dialog, DialogTitle, DialogContent, DialogContentText, DialogActions } from '@mui/material'

type DialogProps = {
  title: string
  description: string
  onSubmit: () => void
  isOpen: boolean
  setOpen: Function
}

const CustomDialog = ({ title, description, isOpen, setOpen, onSubmit }: DialogProps) => {
  const handleClose = () => {
    setOpen(false)
  }

  return (
      <Dialog
        open={isOpen}
        onClose={handleClose}
        aria-labelledby="alert-dialog-title"
        aria-describedby="alert-dialog-description"
      >
        <DialogTitle id="alert-dialog-title">{title}</DialogTitle>
        <DialogContent>
          <DialogContentText id="alert-dialog-description">
            {description}
          </DialogContentText>
        </DialogContent>
        <DialogActions>
          <Button onClick={handleClose} variant="outlined">Cancel</Button>
          <Button onClick={onSubmit} variant="contained" autoFocus>
            Yes
          </Button>
        </DialogActions>
      </Dialog>
  )
}

export default CustomDialog
